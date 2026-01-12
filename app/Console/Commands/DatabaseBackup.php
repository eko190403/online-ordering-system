<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--keep=7 : Number of days to keep backups}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database MySQL ke folder storage/backups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Memulai backup database...');
        
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');
        
        // Create backup directory if not exists
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $filename = "backup_{$dbName}_{$timestamp}.sql";
        $fullPath = $backupPath . '/' . $filename;
        
        // Windows: Find mysqldump from XAMPP
        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe';
        
        if (!file_exists($mysqldumpPath)) {
            $this->error('❌ mysqldump.exe tidak ditemukan di: ' . $mysqldumpPath);
            return 1;
        }
        
        // Build mysqldump command
        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s %s > "%s"',
            $mysqldumpPath,
            $dbUser,
            $dbPass,
            $dbHost,
            $dbName,
            $fullPath
        );
        
        // Execute backup
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($fullPath)) {
            $fileSize = $this->formatBytes(filesize($fullPath));
            $this->info("✅ Backup berhasil!");
            $this->info("📁 File: {$filename}");
            $this->info("💾 Size: {$fileSize}");
            $this->info("📍 Path: {$fullPath}");
            
            // Clean old backups
            $this->cleanOldBackups($backupPath, $this->option('keep'));
            
            return 0;
        } else {
            $this->error('❌ Backup gagal! Return code: ' . $returnCode);
            return 1;
        }
    }
    
    /**
     * Clean old backup files
     */
    private function cleanOldBackups($path, $keepDays)
    {
        $files = glob($path . '/backup_*.sql');
        $now = time();
        $deleted = 0;
        
        foreach ($files as $file) {
            if (is_file($file)) {
                $fileAge = ($now - filemtime($file)) / 86400; // days
                if ($fileAge > $keepDays) {
                    unlink($file);
                    $deleted++;
                }
            }
        }
        
        if ($deleted > 0) {
            $this->info("🗑️  {$deleted} backup lama dihapus (lebih dari {$keepDays} hari)");
        }
    }
    
    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}

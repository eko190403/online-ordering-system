<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin Users
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@cafe.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Categories
        $categories = [
            'Kopi',
            'Teh',
            'Jus',
            'Makanan',
            'Snack',
        ];

        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }

        // Create Sample Menus
        $menus = [
            ['name' => 'Espresso', 'category_id' => 1, 'price' => 15000, 'description' => 'Kopi espresso klasik'],
            ['name' => 'Cappuccino', 'category_id' => 1, 'price' => 20000, 'description' => 'Kopi dengan susu foam'],
            ['name' => 'Latte', 'category_id' => 1, 'price' => 22000, 'description' => 'Kopi susu lembut'],
            ['name' => 'Americano', 'category_id' => 1, 'price' => 18000, 'description' => 'Espresso dengan air panas'],
            ['name' => 'Teh Tarik', 'category_id' => 2, 'price' => 12000, 'description' => 'Teh susu manis'],
            ['name' => 'Green Tea', 'category_id' => 2, 'price' => 15000, 'description' => 'Teh hijau segar'],
            ['name' => 'Jus Jeruk', 'category_id' => 3, 'price' => 15000, 'description' => 'Jus jeruk segar'],
            ['name' => 'Jus Alpukat', 'category_id' => 3, 'price' => 18000, 'description' => 'Jus alpukat creamy'],
            ['name' => 'Nasi Goreng', 'category_id' => 4, 'price' => 25000, 'description' => 'Nasi goreng spesial'],
            ['name' => 'Mie Goreng', 'category_id' => 4, 'price' => 22000, 'description' => 'Mie goreng pedas'],
            ['name' => 'French Fries', 'category_id' => 5, 'price' => 15000, 'description' => 'Kentang goreng crispy'],
            ['name' => 'Onion Rings', 'category_id' => 5, 'price' => 18000, 'description' => 'Bawang goreng renyah'],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}

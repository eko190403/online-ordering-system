<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class PromoController extends Controller
{
    public function validatePromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total_amount' => 'required|numeric'
        ]);

        $promo = Promo::where('code', $request->code)->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Kode promo tidak ditemukan']);
        }

        if (!$promo->is_active) {
            return response()->json(['success' => false, 'message' => 'Kode promo sudah tidak aktif']);
        }

        if ($promo->valid_until && now()->gt($promo->valid_until)) {
            return response()->json(['success' => false, 'message' => 'Kode promo sudah kedaluwarsa']);
        }

        if ($request->total_amount < $promo->min_purchase) {
            return response()->json(['success' => false, 'message' => 'Minimal pembelian untuk promo ini adalah Rp ' . number_format($promo->min_purchase, 0, ',', '.')]);
        }

        $discount = 0;
        if ($promo->discount_type == 'percent') {
            $discount = ($promo->discount_amount / 100) * $request->total_amount;
        } else {
            $discount = $promo->discount_amount;
        }

        // Pastikan diskon tidak melebihi total belanja
        if ($discount > $request->total_amount) {
            $discount = $request->total_amount;
        }

        return response()->json([
            'success' => true,
            'promo_id' => $promo->id,
            'promo_type' => $promo->discount_type,
            'promo_value' => $promo->discount_amount,
            'min_purchase' => $promo->min_purchase,
            'discount_amount' => $discount,
            'message' => 'Promo berhasil digunakan!'
        ]);
    }
}

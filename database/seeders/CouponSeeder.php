<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Illuminate\Support\Str;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $type = ['fixed', 'percentage'][array_rand(['fixed', 'percentage'])];

            // Define valor conforme o tipo
            $value = $type === 'percentage' ? rand(1, 20) : rand(10, 100);

            $name = 'Desconto ' . $value;
            $code = 'DESC' . $value . strtoupper(Str::random(2)); // evitar repetição
            $expiresAt = '2025-08-09 23:59:59';

            Coupon::create([
                'name' => $name,
                'code' => strtoupper(Str::slug($code, '')),
                'type' => $type,
                'value' => $value,
                'expires_at' => $expiresAt,
                'quantity' => rand(10, 50),
            ]);
        }
    }
}

<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    public function findCoupon($code)
    {
        return Coupon::where('code', $code)
        ->firstOrFail();
    }
}

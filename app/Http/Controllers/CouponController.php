<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected CouponService $couponService;

    public function __construct(CouponService $couponService) {
        $this->couponService = $couponService;
    }
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(10);
        return view('coupon.index', compact('coupons'));
    }


    public function create()
    {
        return view('coupon.create');
    }

    public function store(CouponRequest $request)
    {
        $validated = $request->validated();
        Coupon::create($validated);

        return redirect()->route('coupons.index')->with('success', 'Cupom cadastrado com sucesso!');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupon.create', ['coupon' => $coupon]);
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $validated = $request->validated();
        $coupon->update($validated);
        return redirect()->route('coupons.index')->with('success', 'Cupom atualizado com sucesso!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Cupom deletado com sucesso!');
    }

    public function loadCoupon($code)
    {
        $coupon = $this->couponService->findCoupon($code);

        return response()->json($coupon);
    }
}


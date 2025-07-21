<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CouponService;
use App\Services\StockService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected CouponService $couponService;
    protected CartService $cartService;
    protected StockService $stockService;

    public function __construct(CouponService $couponService, CartService $cartService, StockService $stockService) {
        $this->couponService = $couponService;
        $this->cartService = $cartService;
        $this->stockService = $stockService;
    }

    public function index()
    {
        // Pega o customer_id da sessão
        $customer_id = Session::get('selected_customer_id');

        if (!$customer_id) {
            // Se não tiver cliente selecionado, pode redirecionar ou mostrar mensagem
            return redirect()->back()->with('error', 'Cliente não selecionado.');
        }

        // Busca os pedidos do cliente com os relacionamentos, ordenando e paginando
        $orders = Order::with(['customer', 'coupon'])
            ->where('customer_id', $customer_id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Debug - remover na produção
        // dd($orders);

        return view('order.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cep' => ['required', 'regex:/^\d{5}-?\d{3}$/'],
            'coupon_code' => ['nullable', 'string'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'freight_value' => ['required', 'numeric', 'min:0'],
            'final_total' => ['required', 'numeric', 'min:0'],
            'quantities_hidden' => ['required', 'array'],
            'quantities_hidden.*' => ['required', 'integer', 'min:1']
        ]);

        // Revalida o cupom no backend
        $cupom = null;
        if (!empty($data['coupon_code'])) {
            $cupom = Coupon::where('code', $data['coupon_code'])
                ->where('expires_at', '>=', Carbon::now())
                ->where('quantity', '>', 0)
                ->first();

            if (!$cupom) {
                return back()->withErrors(['coupon_code' => 'Cupom inválido ou expirado']);
            }

            // Verifica se o desconto está correto
            $expectedDiscount = $cupom->type === 'percentage'
                ? $data['subtotal'] * ($cupom->value / 100)
                : $cupom->value;

            if (abs($expectedDiscount - $data['discount_value']) > 0.01) {
                return back()->withErrors(['discount_value' => 'Desconto inválido.']);
            }

            // Reduz quantidade do cupom
            $cupom->decrement('quantity');
        }

        // Armazena tudo na sessão
        Session::put('checkout', [
            'cep' => $data['cep'],
            'coupon_code' => $data['coupon_code'],
            'subtotal' => $data['subtotal'],
            'discount' => $data['discount_value'],
            'freight' => $data['freight_value'],
            'total' => $data['final_total'],
            'quantities' => $data['quantities_hidden'],
        ]);
        $products = array_values(session('cart'));


        $data = [
            'products' => $products,
            'order' => session('checkout'),
            'customer_id' => session('selected_customer_id'),
        ];

        if($data['order']['coupon_code']) {
            $coupon = $this->couponService->findCoupon($data['order']['coupon_code']);
        }

        $order = Order::create([
            'customer_id' => session('selected_customer_id'),
            'amount' => $data['order']['subtotal'],
            'discount' => $data['order']['discount'],
            'coupon_id' => $coupon->id ?? null,
            'shipping' => $data['order']['freight'],
        ]);

        $data['order_id'] = $order->id;
        $this->cartService->vinculateCart($data);
        $this->stockService->debitStock($data);

        Session::forget(['cart', 'checkout']);

        return redirect()->route('home.index')->with('message', 'Pedido processado com sucesso!');
    }

    public function generatePdf($orderId)
    {
        $order = Order::with('customer', 'carts')->findOrFail($orderId);

        $pdf = Pdf::loadView('emails.order_summary', [
            'order' => $order,
            'customer' => $order->customer
        ]);

        return $pdf->stream("pedido_{$order->id}.pdf");
    }

}

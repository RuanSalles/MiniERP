<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Home;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all()->count();
        $products = Product::all()->count();
        $orders = Order::all()->count();
        $data = [
            'customers' => $customers,
            'products' => $products,
            'orders' => $orders
        ];
        return view('home.home', ['data' => $data]);
    }


}

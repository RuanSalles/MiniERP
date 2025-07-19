<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use app\Services\CustomerService;
use Illuminate\Http\Request;
use Mockery\Exception;

class CustomerController extends Controller
{

    protected $customerService;
    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;
    }

    public function index() {
        $customers = Customer::all()->withRelationshipAutoloading();
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(CustomerRequest $request)
    {
        try {
            $validated = $request->validated();

            $customer = Customer::create($validated);

            $this->customerService->vinculateAddress($validated, $customer);

            return redirect()->route('customer.index')
                ->with('success', 'Cliente cadastrado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao cadastrar cliente: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocorreu um erro ao salvar o cliente.');
        }
    }

}

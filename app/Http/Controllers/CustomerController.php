<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use app\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;

class CustomerController extends Controller
{

    protected $customerService;
    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;
    }

    public function index() {

        $customers = Customer::with('address')->paginate(10);

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

            $this->customerService->vinculateAddress($request->all(), $customer);

            return redirect()->route('customers.index')
                ->with('success', 'Cliente cadastrado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao cadastrar cliente: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocorreu um erro ao salvar o cliente.');
        }
    }

    public function select($id)
    {
        // Verifica se o cliente existe
        $customer = Customer::findOrFail($id);

        Session::flush();

        // Cria uma nova sessão com o ID do cliente selecionado
        Session::put('selected_customer_id', $customer->id);

        return redirect()->route('customers.index')->with('success', 'Cliente selecionado com sucesso!');
    }

}

<?php

namespace app\Services;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function vinculateAddress($payload, $customer)
    {

        try {
            DB::beginTransaction();

            $address = Address::create($payload);
            $customer->update(['address_id' => $address->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // Opcional: log do erro
            \Log::error('Erro ao vincular endereço: ' . $e->getMessage());

            // Rejeita a exceção para o controller tratar
            throw $e;
        }

    }
}

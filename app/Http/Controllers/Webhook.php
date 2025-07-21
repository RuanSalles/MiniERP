<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class Webhook extends Controller
{
    public function updateStatus($id, $status = null)
    {
        try {

            $arrStatus = [
                'processing','completed','cancelled'
            ];

            $order = Order::find($id);
            if (!$order) {
                return response()->json(['error' => 'Pedido não encontrado'], 404);
            }

            // Escolhe status aleatório do array recebido
            $randomStatus = $arrStatus[random_int(0,2)];

            // Atualiza o status do pedido
            $order->status = $status ?? $randomStatus;
            $order->save();

            // Atualiza os carts vinculados ao pedido para status "finished"
            $order->carts()->update(['status' => 'finished']);


            // Atualiza os carts vinculados ao pedido para status "finished"
            Cart::where('order_id', $order->id)
                ->update(['status' => 'finished']);

            return response()->json([
                'message' => 'Status atualizado com sucesso',
                'order_id' => $order->id,
                'new_status' => $randomStatus,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}

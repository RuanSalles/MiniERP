<?php

namespace App\Http\Controllers;

use App\Mail\OrderSummaryMail;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Webhook extends Controller
{
    public function updateStatus($id, $status = null)
    {
        try {
            $arrStatus = ['processing', 'completed', 'cancelled'];

            $order = Order::find($id);
            if (!$order) {
                return response()->json(['error' => 'Pedido não encontrado'], 404);
            }

            // Define o novo status (fornecido ou aleatório)
            $newStatus = $status ?? $arrStatus[random_int(0, count($arrStatus) - 1)];
            $order->status = $newStatus;
            $order->save();

            // Atualiza os carts vinculados ao pedido para "finished"
            $order->carts()->update(['status' => 'finished']);

            // Envia e-mail com resumo do pedido
            if ($order->customer && $order->customer->email) {
                Mail::to($order->customer->email)->send(new OrderSummaryMail($order));
            }

            return response()->json([
                'message' => 'Status atualizado com sucesso',
                'order_id' => $order->id,
                'new_status' => $newStatus,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
        }
    }

}

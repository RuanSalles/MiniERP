<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Resumo do seu Pedido')
            ->view('emails.order_summary') // sua view HTML
            ->with([
                'order' => $this->order,
                'customer' => $this->order->customer,
            ]);
    }
}

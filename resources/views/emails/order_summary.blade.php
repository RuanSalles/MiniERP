<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resumo do Pedido</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px;">

<div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

    <h2 style="color: #333333;">Olá {{ $customer->name }},</h2>

    <p style="font-size: 16px; color: #555;">
        Agradecemos por sua compra! Aqui está o resumo do seu pedido <strong>#{{ $order->id }}</strong>.
    </p>

    <hr style="border: none; border-top: 1px solid #dddddd; margin: 20px 0;">

    <h4 style="color: #333;">Itens do Pedido</h4>
    <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
        <thead>
        <tr style="background-color: #f2f2f2; text-align: left;">
            <th style="border: 1px solid #ddd;">Produto</th>
            <th style="border: 1px solid #ddd;">Quantidade</th>
            <th style="border: 1px solid #ddd;">Valor Unitário</th>
            <th style="border: 1px solid #ddd;">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->carts as $item)
            @foreach($item['products'] as $product)
            <tr>
                <td style="border: 1px solid #ddd;">{{ $product['product_name'] }}</td>
                <td style="border: 1px solid #ddd;">{{ $product['quantity'] }}</td>
                <td style="border: 1px solid #ddd;">R$ {{ number_format($product['amount'], 2, ',', '.') }}</td>
                <td style="border: 1px solid #ddd;">R$ {{ number_format($product['quantity'] * $product['amount'], 2, ',', '.') }}</td>
            </tr>
        @endforeach
        @endforeach
        </tbody>
    </table>

    <hr style="border: none; border-top: 1px solid #dddddd; margin: 20px 0;">

    <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 16px;">
        <tr>
            <td style="text-align: right;">Subtotal:</td>
            <td style="text-align: right;">R$ {{ number_format($order->amount + $order->discount, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="text-align: right;">Desconto:</td>
            <td style="text-align: right;">- R$ {{ number_format($order->discount, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="text-align: right;">Frete:</td>
            <td style="text-align: right;">R$ {{ number_format($order->shipping ?? 0, 2, ',', '.') }}</td>
        </tr>
        <tr style="font-weight: bold;">
            <td style="text-align: right;">Total:</td>
            <td style="text-align: right;">R$ {{ number_format($order->amount + $order->shipping, 2, ',', '.') }}</td>
        </tr>
    </table>

    <p style="margin-top: 30px; font-size: 14px; color: #999;">
        Caso tenha dúvidas, entre em contato com nosso suporte.
    </p>

    <p style="font-size: 14px; color: #999;">Equipe DevStore</p>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas Diarias</title>
    <style>
        /* Estilos similares a los de la factura */
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Ventas del Día</h1>
        <p>Fecha: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id_order }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->total, 2) }} $</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="totals">
            <p>Total Ventas: {{ number_format($total_sales, 2) }} $</p>
        </div>
    </div>
</body>
</html>

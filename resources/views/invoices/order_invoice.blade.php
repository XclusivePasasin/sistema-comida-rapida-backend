<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Pedido</title>
    <style>
        /* Reset de estilos básicos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos generales */
        body, html {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            /* background-color: #f3f4f6; */
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        /* Contenedor principal */
        .container {
            background-color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            max-width: 768px; /* Ancho ajustado */
            width: 100%;
            padding: 1.5rem; /* Espaciado ajustado */
        }

        /* Encabezado */
        .header, .totals, .client-info, .order-details {
            margin-bottom: 1.5rem; /* Espacio entre secciones */
        }

        .header-title {
            font-size: 1.35rem; /* Tamaño moderado para el título */
            font-weight: bold;
            color: #1f2937;
        }

        .header-text, .client-info p, .order-details th, .order-details td, .totals span {
            font-size: 0.875rem; /* Tamaño de texto estándar */
            color: #4b5563;
        }

        .header-subtitle {
            font-weight: bold;
            color: #2563eb;
            font-size: 1rem; /* Tamaño moderado */
        }

        /* Información del Cliente */
        .client-info {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1.5rem; 
            width: calc(100% + 2rem); /* Expandir ligeramente más para ocupar todo el ancho */
            margin-left: -1.5rem; /* Ajusta según el padding del contenedor padre */
        }

        .client-info h2 {
            font-size: 1rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 0.4rem;
        }

        /* Tabla de detalles del pedido */
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th, .order-details td {
            padding: 0.65rem 0.75rem; /* Espaciado compacto */
            text-align: left;
        }

        .order-details th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .order-details td {
            color: #1f2937;
        }

        .text-right {
            text-align: right;
        }

        .border-b {
            border-bottom: 1px solid #e5e7eb;
        }

        /* Totales */
        .totals {
            border-top: 1px solid #e5e7eb;
            padding-top: 1.2rem; /* Espacio ajustado */
        }

        .totals .total-label {
            color: #4b5563;
        }

        .totals .total-value {
            font-weight: bold;
            font-size: 1.05rem; /* Tamaño destacado para el total */
            color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado de la Empresa y Datos de la Factura -->
        <div class="header flex" style="display: flex; justify-content: space-between;">
            <div>
                <h1 class="header-title">FastFood S.A de C.V.</h1>
                <p class="header-text">CIF/NIT: 12345678A</p>
            </div>
            <div style="margin-right: 20px; text-align: right;">
                <p class="header-title" style="color: #1f2937; font-weight: bold; font-size: 1rem;" >Número de factura:</p>
                <p class="header-subtitle">Pedido #{{ $order->id_order }}</p>
                <p class="header-text">Fecha Factura:</p>
                <p class="header-text">{{ $order->order_date }}</p>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="client-info">
            <h2>Cliente:</h2>
            <p>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
            <p>DUI: {{ $order->customer->dui }}</p>
            <p>Dirección: {{ $order->customer->address ?? 'Dirección desconocida' }}</p>
        </div>

        <!-- Detalles del Pedido -->
        <div class="order-details">
            <table>
                <thead>
                    <tr>
                        <th>Dish</th>
                        <th>Price</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        <tr class="border-b">
                            <td>{{ $detail->dish->dish_name }}</td>
                            <td>{{ $detail->dish->price }} </td>
                            <td class="text-right">{{ $detail->quantity }}</td>
                            <td class="text-right">{{ number_format($detail->subtotal, 2) }} $</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totales de la Factura -->
        <div class="totals">
            <div class="flex justify-between">
                <span class="total-label">Total Base Imponible:</span>
                <span>{{ number_format($order->total - ($order->total * 0.21), 2) }} $</span>
            </div>
            <div class="flex justify-between">
                <span class="total-label">I.V.A. 21%:</span>
                <span>{{ number_format($order->total * 0.21, 2) }} $</span>
            </div>
            <div class="flex justify-between">
                <span class="total-label">Retención 15%:</span>
                <span>-{{ number_format($order->total * 0.15, 2) }} $</span>
            </div>
            <div class="flex justify-between">
                <span class="total-label">TOTAL:</span>
                <span class="total-value">{{ number_format($order->total, 2) }} $</span>
            </div>
        </div>
    </div>
</body>
</html>

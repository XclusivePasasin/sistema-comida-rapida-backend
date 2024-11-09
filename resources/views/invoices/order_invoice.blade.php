<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        /* Basic style reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General styles */
        body, html {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        /* Main container */
        .container {
            background-color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            max-width: 768px;
            width: 100%;
            padding: 1.5rem;
        }

        /* Header */
        .header, .totals, .client-info, .order-details {
            margin-bottom: 1.5rem;
        }

        .header-title {
            font-size: 1.35rem;
            font-weight: bold;
            color: #1f2937;
        }

        .header-text, .client-info p, .order-details th, .order-details td, .totals span {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .header-subtitle {
            font-weight: bold;
            color: #2563eb;
            font-size: 1rem;
        }

        /* Client Information */
        .client-info {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1.5rem;
            width: calc(100% + 2rem);
            margin-left: -1.5rem;
        }

        .client-info h2 {
            font-size: 1rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 0.4rem;
        }

        /* Order Details Table */
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th, .order-details td {
            padding: 0.65rem 0.75rem;
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

        /* Totals */
        .totals {
            border-top: 1px solid #e5e7eb;
            padding-top: 1.2rem;
        }

        .totals .total-label {
            color: #4b5563;
        }

        .totals .total-value {
            font-weight: bold;
            font-size: 1.05rem;
            color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Company Header and Invoice Information -->
        <div class="header flex" style="display: flex; justify-content: space-between;">
            <div>
                <h1 class="header-title">FastFood S.A de C.V.</h1>
                <p class="header-text">CIF/NIT: 12345678A</p>
            </div>
            <div style="margin-right: 20px; text-align: right;">
                <p class="header-title" style="color: #1f2937; font-weight: bold; font-size: 1rem;">Invoice Number:</p>
                <p class="header-subtitle">Order #{{ $order->id_order }}</p>
                <p class="header-text">Invoice Date:</p>
                <p class="header-text">{{ $order->order_date }}</p>
            </div>
        </div>

        <!-- Client Information -->
        <div class="client-info">
            <h2>Client:</h2>
            <p>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
            <p>DUI: {{ $order->customer->dui }}</p>
            <p>Address: {{ $order->customer->address ?? 'Unknown Address' }}</p>
        </div>

        <!-- Order Details -->
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

        <!-- Invoice Totals -->
        <div class="totals">
            <div class="flex justify-between">
                <span class="total-label">Taxable Base Total:</span>
                <span>{{ number_format($order->total - ($order->total * 0.21), 2) }} $</span>
            </div>
            <div class="flex justify-between">
                <span class="total-label">VAT 21%:</span>
                <span>{{ number_format($order->total * 0.21, 2) }} $</span>
            </div>
            <div class="flex justify-between">
                <span class="total-label">Retention 15%:</span>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Periodic Sales Report</title>
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
        .header-title {
            font-size: 1.35rem;
            font-weight: bold;
            color: #1f2937;
            text-align: center;
            margin-bottom: 1rem;
        }

        .header-text {
            font-size: 0.875rem;
            color: #4b5563;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* Report details table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        th, td {
            padding: 0.65rem;
            text-align: center;
        }

        th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #1f2937;
        }

        td {
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        /* Totals */
        .totals {
            margin-top: 1.5rem;
            padding-top: 1.2rem;
            border-top: 1px solid #e5e7eb;
            text-align: left;
            font-weight: bold;
            font-size: 1.05rem;
            color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Company Information -->
        <div>
            <h1 class="header-title">FastFood S.A de C.V.</h1>
            <p class="header-text">CIF/NIT: 12345678A</p>
        </div>

        <!-- Report header -->
        <h1 class="header-title">Periodic Sales Report</h1>
        <p class="header-text">Period: {{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}</p>

        <!-- Sales details table -->
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Customer Name</th>
                    <th>Customer</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id_order }}</td>
                    <td class="text-center">{{ $order->user->username  }}</td>
                    <td class="text-center">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                    <td>{{ $order->customer_dui }}</td>
                    <td>{{ number_format($order->total, 2) }} $</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <p>Total Sales: {{ number_format($total_sales, 2) }} $</p>
        </div>
    </div>
</body>
</html>

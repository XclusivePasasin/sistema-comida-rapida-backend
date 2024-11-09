<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales by Category Report</title>
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
            padding: 0.65rem 0.75rem;
            text-align: left;
        }

        th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #1f2937;
        }

        td {
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
        }

        .text-center {
            text-align: center;
        }

        /* Totals */
        .totals {
            margin-top: 1.5rem;
            padding-top: 1.2rem;
            border-top: 1px solid #e5e7eb;
        }

        .totals .total-label {
            color: #4b5563;
            font-size: 0.875rem;
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
        <!-- Company Information -->
        <div>
            <h1 class="header-title">FastFood S.A de C.V.</h1>
            <p class="header-text">CIF/NIT: 12345678A</p>
        </div>

        <!-- Report header -->
        <h1 class="header-title">Sales by Category Report</h1>
        <p class="header-text">{{ $start_date }} to {{ $end_date }}</p>

        <!-- Sales by category table -->
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th class="text-center">Total Sales</th>
                    <th class="text-center">Items Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_by_category as $category => $data)
                <tr>
                    <td>{{ $category }}</td>
                    <td class="text-center">{{ number_format($data['total_sales'], 2) }} $</td>
                    <td class="text-center">{{ $data['items_sold'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="flex justify-between">
                <span class="total-label">Total Sales:</span>
                <span class="total-value">{{ number_format($total_sales, 2) }} $</span>
            </div>
            <div class="flex justify-between">
                <span class="total-label">Total Items Sold:</span>
                <span class="total-value">{{ $total_items }}</span>
            </div>
        </div>
    </div>
</body>
</html>

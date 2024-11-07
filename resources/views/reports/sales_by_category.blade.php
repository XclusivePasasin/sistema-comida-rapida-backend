<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas por Categoría</title>
    <style>
        /* Estilos similares a los de la factura */
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Ventas por Categoría</h1>
        <p>Desde {{ $start_date }} hasta {{ $end_date }}</p>
        <table>
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Total Ventas</th>
                    <th>Items Vendidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_by_category as $category => $data)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ number_format($data['total_sales'], 2) }} $</td>
                    <td>{{ $data['items_sold'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

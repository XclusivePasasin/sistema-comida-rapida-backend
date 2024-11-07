<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Exception;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // endpoint for get all orders
    public function showOrders()
    {
        try {
            $orders = Order::all();
            if ($orders->count() == 0) {
                return response()->json(
                    ['code' => 404, 'message' => 'No orders found'], 404
                );    
            } else {
                return response()->json(
                    ['code' => 200, 'message' => 'Orders found', 'orders' => $orders], 200
                );
            }
            }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    //endpoint for create order
    public function createOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_user' => 'required|integer',
                'order_date' => 'required|date',
                'customer_dui' => 'required|string|max:10',
                'id_table' => 'required|integer',
                'status' => 'required|int|max:1',
                'total' => 'required|numeric|min:0',
                'payment_method' => 'required|string|max:40'
            ]);
            if ($validator->fails()) {  
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
            $order = Order::create($request->all());
            return response()->json(
                ['code' => 201, 'message' => 'Order created', 'order' => $order], 201
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for update order status or payment_method
    public function updateOrder(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|integer|max:2', 
                'payment_method' => 'nullable|string|max:40' 
            ]);
    
            if ($validator->fails()) {
                return response()->json(
                    ['code' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400
                );
            }
    
            $order = Order::find($id); 
    
            if (!$order) {
                return response()->json(
                    ['code' => 404, 'message' => 'Order not found'], 404
                );
            }
    
            $order->update($request->only(['status', 'payment_method']));
    
            return response()->json(
                ['code' => 200, 'message' => 'Order updated', 'order' => $order], 200
            );
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for generate invoice
    public function generateInvoice($order_id)
    {
        try {
            
            $filePath = public_path("facturas/Factura_Order_{$order_id}.pdf");
    
          
            if (!File::exists(public_path('facturas'))) {
                File::makeDirectory(public_path('facturas'), 0755, true);
            }
    
            
            if (file_exists($filePath)) {
                return response()->json([
                    'file_url' => asset("facturas/Factura_Order_{$order_id}.pdf"),
                    'message' => 'Factura ya existente'
                ]);
            }
    
            
            $order = Order::with('details.dish')->findOrFail($order_id);
            $pdf = PDF::loadView('invoices.order_invoice', compact('order'));
    
            
            $pdf->save($filePath);
    
            return response()->json([
                'file_url' => asset("facturas/Factura_Order_{$order_id}.pdf"),
                'message' => 'Factura generada exitosamente'
            ]);
        } catch (Exception $e) {
            \Log::error("Error generating invoice: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error generating invoice', 'error' => $e->getMessage()],
                500
            );
        }
    }
    



    // endpoint for delete order
    public function deleteOrder(Request $request, $id)
    {
        try {
            $order = Order::find($request->id_order);
            $order->delete();
            return response()->json(
                ['code' => 200, 'message' => 'Order deleted', 'order' => $order], 200
            );
        }
        catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    public function getNextOrderId()
    {
        $lastOrder = Order::orderBy('id_order', 'desc')->first();

        $nextOrderId = $lastOrder ? $lastOrder->id_order + 1 : 1;

        return response()->json(['next_order_id' => $nextOrderId], 200);
    }

    public function showOrdersByStatus($status)
    {
        try {
            if (!in_array($status, [0, 1, 2, 3])) { 
                return response()->json(
                    ['code' => 400, 'message' => 'Invalid status parameter'], 400
                );
            }

            $orders = ($status == 3) 
                ? Order::with(['customer', 'table'])->get()
                : Order::where('status', $status)->with(['customer', 'table'])->get();

            if ($orders->isEmpty()) {
                $statusMessages = [
                    0 => 'No pending orders found',
                    1 => 'No orders in delivery found',
                    2 => 'No paid orders found',
                    3 => 'No orders found' 
                ];
                return response()->json(
                    ['code' => 404, 'message' => $statusMessages[$status]], 404
                );
            } else {
                $statusMessages = [
                    0 => 'Pending orders found',
                    1 => 'Orders in delivery found',
                    2 => 'Paid orders found',
                    3 => 'All orders found' 
                ];

                $formattedOrders = $orders->map(function ($order) {
                    return [
                        'id_order' => $order->id_order,
                        'customer_name' => $order->customer ? $order->customer->first_name . ' ' . $order->customer->last_name : 'Unknown Customer',
                        'customer_dui' => $order->customer ? $order->customer->dui : 'Unknown Customer',
                        'id_table' => $order->table ? $order->table->id_table : 'No Table Assigned',
                        'table_name' => $order->table ? $order->table->table_number : 'No Table Assigned',
                        'total' => $order->total,
                        'status' => $order->status,
                        'order_date' => $order->order_date,
                    ];
                });

                return response()->json(
                    [
                        'code' => 200,
                        'message' => $statusMessages[$status],
                        'orders' => $formattedOrders
                    ], 200
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['code' => 500, 'message' => 'Internal server error'], 500
            );
        }
    }

    // endpoint for get daily sales
    public function generateDailySalesReport()
    {
        try {
            $filePath = public_path("reports/Daily_Sales_Report_" . now()->toDateString() . ".pdf");

            if (!File::exists(public_path('reports'))) {
                File::makeDirectory(public_path('reports'), 0755, true);
            }

            if (file_exists($filePath)) {
                return response()->json([
                    'file_url' => asset("reports/Daily_Sales_Report_" . now()->toDateString() . ".pdf"),
                    'message' => 'Reporte diario ya existente'
                ]);
            }

            $today = now()->startOfDay();
            $orders = Order::where('order_date', '>=', $today)->where('status', 2)->get();
            $totalSales = $orders->sum('total');

            $pdf = PDF::loadView('reports.daily_sales', [
                'orders' => $orders,
                'total_sales' => $totalSales
            ]);

            $pdf->save($filePath);

            return response()->json([
                'file_url' => asset("reports/Daily_Sales_Report_" . now()->toDateString() . ".pdf"),
                'message' => 'Reporte diario generado exitosamente'
            ]);
        } catch (Exception $e) {
            \Log::error("Error generating daily sales report: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error al generar el reporte diario', 'error' => $e->getMessage()],
                500
            );
        }
    }


    //endpoint for get monthly sales
    public function generatePeriodicSalesReport(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'period' => 'required|string|in:weekly,monthly'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Parámetro de período no válido',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            $period = $request->period;
            $fileName = "Periodic_Sales_Report_{$period}_" . now()->toDateString() . ".pdf";
            $filePath = public_path("reports/{$fileName}");
    
            if (!File::exists(public_path('reports'))) {
                File::makeDirectory(public_path('reports'), 0755, true);
            }
    
            if (file_exists($filePath)) {
                return response()->json([
                    'file_url' => asset("reports/{$fileName}"),
                    'message' => "Reporte de ventas {$period} ya existente"
                ]);
            }
    
            $startDate = now();
            if ($period === 'weekly') {
                $startDate = $startDate->startOfWeek();
            } elseif ($period === 'monthly') {
                $startDate = $startDate->startOfMonth();
            }
    
            $orders = Order::where('order_date', '>=', $startDate)->where('status', 2)->get();
            $totalSales = $orders->sum('total');
    
            $pdf = PDF::loadView('reports.periodic_sales', [
                'orders' => $orders,
                'total_sales' => $totalSales,
                'period' => $period,
                'startDate' => $startDate
            ]);
    
            $pdf->save($filePath);
    
            return response()->json([
                'file_url' => asset("reports/{$fileName}"),
                'message' => "Reporte de ventas {$period} generado exitosamente"
            ]);
        } catch (Exception $e) {
            \Log::error("Error generating periodic sales report: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error al generar el reporte periódico', 'error' => $e->getMessage()],
                500
            );
        }
    }

    public function generateSalesByCategoryReport(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Error en la validación de fechas',
                    'errors' => $validator->errors()
                ], 400);
            }

            $fileName = "Sales_By_Category_Report_{$request->start_date}_to_{$request->end_date}.pdf";
            $filePath = public_path("reports/{$fileName}");

            if (!File::exists(public_path('reports'))) {
                File::makeDirectory(public_path('reports'), 0755, true);
            }

            if (file_exists($filePath)) {
                return response()->json([
                    'file_url' => asset("reports/{$fileName}"),
                    'message' => 'Reporte de ventas por categoría ya existente'
                ]);
            }

            $orders = Order::with(['details.dish.category'])
                            ->whereBetween('order_date', [$request->start_date, $request->end_date])
                            ->where('status', 2)->get();

            $salesByCategory = $orders->flatMap(function ($order) {
                return $order->details;
            })->groupBy(function ($detail) {
                return $detail->dish->category->name;
            })->map(function ($group) {
                return [
                    'total_sales' => $group->sum('subtotal'),
                    'items_sold' => $group->sum('quantity')
                ];
            });

            $pdf = PDF::loadView('reports.sales_by_category', [
                'sales_by_category' => $salesByCategory,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            $pdf->save($filePath);

            return response()->json([
                'file_url' => asset("reports/{$fileName}"),
                'message' => 'Reporte de ventas por categoría generado exitosamente'
            ]);
        } catch (Exception $e) {
            \Log::error("Error generating sales by category report: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error al generar el reporte de ventas por categoría', 'error' => $e->getMessage()],
                500
            );
        }
    }





}

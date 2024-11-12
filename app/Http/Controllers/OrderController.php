<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Detail_order;
use App\Models\Dish;
use Exception;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class OrderController extends Controller
{
    // endpoint for get dashboard metrics
    public function getDashboardMetrics()
    {
        try {
            $today = Carbon::now()->startOfDay();
            $startOfMonth = Carbon::now()->startOfMonth();
    
            $totalSalesToday = Order::where('status', 2)
                                    ->whereDate('order_date', $today)
                                    ->sum('total');
    
            $totalSalesMonth = Order::where('status', 2)
                                    ->whereDate('order_date', '>=', $startOfMonth)
                                    ->sum('total');
    
            $completedOrders = Order::where('status', 2)->count();
            $pendingOrders = Order::where('status', 0)->count();
    
            $topDishes = Detail_order::select('id_dish', \DB::raw('SUM(quantity) as total_quantity'))
                                    ->with('dish') 
                                    ->groupBy('id_dish')
                                    ->orderByDesc('total_quantity')
                                    ->limit(5)
                                    ->get();
    
            $topDishesData = $topDishes->map(function ($detail) {
                return [
                    'dish_name' => $detail->dish ? $detail->dish->dish_name : 'Platillo desconocido',
                    'quantity_sold' => $detail->total_quantity,
                ];
            });
    
            return response()->json([
                'code' => 200,
                'message' => 'Dashboard metrics retrieved successfully',
                'data' => [
                    'total_sales_today' => $totalSalesToday,
                    'total_sales_month' => $totalSalesMonth,
                    'completed_orders' => $completedOrders,
                    'pending_orders' => $pendingOrders,
                    'top_selling_dishes' => $topDishesData,
                ]
            ], 200);
        } catch (Exception $e) {
            \Log::error("Error retrieving dashboard metrics: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error retrieving dashboard metrics', 'error' => $e->getMessage()],
                500
            );
        }
    }

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
                File::delete($filePath); 
            }

            $order = Order::with('details.dish')->findOrFail($order_id);
            
            $pdf = PDF::loadView('invoices.order_invoice', compact('order'));

            $pdf->save($filePath);

            return response()->json([
                'file_url' => asset("facturas/Factura_Order_{$order_id}.pdf"),
                'message' => 'Invoice generated successfully'
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
    public function generateDailySalesReport(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'The date is required and must be in a valid format.',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            $reportDate = Carbon::parse($request->date)->startOfDay();
            $filePath = public_path("reports/Daily_Sales_Report_" . $reportDate->toDateString() . ".pdf");
    
            if (!File::exists(public_path('reports'))) {
                File::makeDirectory(public_path('reports'), 0755, true);
            }
    
            if (file_exists($filePath)) {
                File::delete($filePath);
            }
    
            $orders = Order::with(['customer', 'user']) 
                            ->whereDate('order_date', $reportDate)
                            ->where('status', 2)
                            ->get();
    
            $totalSales = $orders->sum('total');
    
            $pdf = PDF::loadView('reports.daily_sales', [
                'orders' => $orders,
                'total_sales' => $totalSales,
                'report_date' => $reportDate->toDateString() 
            ]);
    
            $pdf->save($filePath);
    
            return response()->json([
                'file_url' => asset("reports/Daily_Sales_Report_" . $reportDate->toDateString() . ".pdf"),
                'message' => 'Daily report generated successfully'
            ]);
        } catch (Exception $e) {
            \Log::error("Error generating daily sales report: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error generating the daily report', 'error' => $e->getMessage()],
                500
            );
        }
    }

    //endpoint for get monthly sales
    public function generatePeriodicSalesReport(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Parámetros de fecha no válidos',
                    'errors' => $validator->errors()
                ], 400);
            }
    
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
    
            $period = $startDate->diffInDays($endDate) <= 7 ? 'semanal' : 'mensual';
    
            $fileName = "Periodic_Sales_Report_{$startDate->toDateString()}_to_{$endDate->toDateString()}.pdf";
            $filePath = public_path("reports/{$fileName}");
    
            if (!File::exists(public_path('reports'))) {
                File::makeDirectory(public_path('reports'), 0755, true);
            }
    
            if (file_exists($filePath)) {
                File::delete($filePath);
            }
    
            $orders = Order::with(['customer', 'user'])
                            ->whereBetween('order_date', [$startDate, $endDate])
                            ->where('status', 2)
                            ->get();
            $totalSales = $orders->sum('total');
    
            $pdf = PDF::loadView('reports.periodic_sales', [
                'orders' => $orders,
                'total_sales' => $totalSales,
                'period' => $period, 
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
    
            $pdf->save($filePath);
    
            return response()->json([
                'file_url' => asset("reports/{$fileName}"),
                'message' => "Sales report generated successfully"
            ]);
        } catch (Exception $e) {
            \Log::error("Error generating periodic sales report: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error generating the report', 'error' => $e->getMessage()],
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
                File::delete($filePath);
            }
    
            $orders = Order::with(['details.dish.category'])
                ->whereBetween('order_date', [$request->start_date, $request->end_date])
                ->where('status', 2)
                ->get();
    
            $salesByCategory = $orders->flatMap(function ($order) {
                return $order->details->map(function ($detail) {
                    return [
                        'category' => $detail->dish->category->name,
                        'subtotal' => $detail->subtotal,
                        'quantity' => $detail->quantity,
                    ];
                });
            })->groupBy('category')->map(function ($items) {
                return [
                    'total_sales' => $items->sum('subtotal'),
                    'items_sold' => $items->sum('quantity'),
                ];
            });
    
            $totalSales = $salesByCategory->sum('total_sales');
            $totalItems = $salesByCategory->sum('items_sold');
    
            $pdf = PDF::loadView('reports.sales_by_category', [
                'sales_by_category' => $salesByCategory,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_sales' => $totalSales,
                'total_items' => $totalItems,
            ]);
    
            $pdf->save($filePath);
    
            return response()->json([
                'file_url' => asset("reports/{$fileName}"),
                'message' => 'Sales report by category successfully generated'
            ]);
        } catch (Exception $e) {
            \Log::error("Error generating sales by category report: " . $e->getMessage());
            return response()->json(
                ['code' => 500, 'message' => 'Error when generating the sales report by category', 'error' => $e->getMessage()],
                500
            );
        }
    }

}

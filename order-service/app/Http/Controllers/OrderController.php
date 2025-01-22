<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderCancelled;
use App\Services\OrderService;
use App\Models\Order;


class OrderController extends Controller
{
    protected OrderService $orderService;
    public function __construct() {
        $this->orderService = new OrderService();
    }

    // Method to retrieve all orders
    public function index(Request $request)
    {
        $orders =  $this->orderService->list();
        return response()->json($orders);
    }

    // Method to create a new order
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate($this->orderService->validateArray());
            
            // Create the order after validation
            $order = $this->orderService->create($validatedData);
            return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    
        } catch (Throwable $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        }    }


    // Method to update an order
    public function update(Request $request, $id)
    {
        // Find the order by ID
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $validatedData = $request->validate( $request->validate($this->orderService->validateArray()));
        try{     
            $this->orderService->update($validatedData, $id);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 404);

        }        return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
    }

    // Method to delete an order
    public function destroy($id)
    {
        try{
            $this->orderService->destroy($id);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 404);
        }

        return response()->json(['message' => 'Order deleted successfully']);
    }
}

?>

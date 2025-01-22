<?php

namespace App\Services;
use App\Events\OrderPlaced;
use App\Models\Order;

class OrderService
{
    public function list()
    {
        // Place order logic here
       
        return  Order::all();
    }

    public function create($orderData){
        $order = Order::create([
            'user_id' => $orderData['user_id'],
            'product_name' => $orderData['product_name'],
            'status' => $orderData['status'],
            'total_amount' => $orderData['total_amount'],
            'shipping_address' => $orderData['shipping_address'],
        ]);
        event(new OrderPlaced($order));
        return $order;
    }

    public function update($orderData, $id)
    {
        // Find the order by ID
        $order = Order::find($id);

        if (!$order) {
           throw new \Exception('Order not found');
        }

        // Update the order with validated data
        $order->update($orderData);

        return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
    }
    public function validateArray(){
        return [
            'user_id' => 'required|exists:users,id',
            'product_name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'total_amount' => 'required|numeric',
            'shipping_address' => 'required|string',
        ];
    }

    public function destroy($orderId){
        $order = Order::find($orderId);
        if (!$order) {
            throw new \Exception('Order not found');
        }
        $order->delete();
        event(new OrderCancelled($order));
        return true;
    }
}
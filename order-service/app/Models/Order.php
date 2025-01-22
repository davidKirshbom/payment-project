<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define the table name (optional if it's the default 'orders')
    protected $table = 'orders';

    // Define the fillable attributes
    protected $fillable = [
        'user_id',          // Assuming orders are linked to a user
        'product_name',     // Added product_name for the product associated with the order
        'status',           // Order status like 'pending', 'completed', 'canceled'
        'total_amount',     // The total cost of the order
        'shipping_address', // Address for the order
        // Add any other fields that belong to your orders table
    ];

    // Define relationships (e.g., an order belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class);  // Assuming each order belongs to a user
    }

    // You can add relationships for products if you have a product table
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);  // Assuming a Product model exists
    // }
}
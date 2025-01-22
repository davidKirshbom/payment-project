<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add new columns to the orders table
            $table->decimal('total_amount', 8, 2);  // Column for total amount (with precision 8, scale 2)
            $table->text('shipping_address');  // Column for shipping address
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the columns if rolling back the migration
            $table->dropColumn([ 'total_amount', 'shipping_address']);
        });
    }
};

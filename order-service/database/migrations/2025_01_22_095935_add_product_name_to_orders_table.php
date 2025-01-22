<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('product_name');  // Add the product_name column to orders table
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('product_name');  // Drop the product_name column if rolling back
        });
    }
};

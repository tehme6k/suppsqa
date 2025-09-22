<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('quarantine_user')->nullable()->references('id')->on('users')->constrained();
            $table->foreignId('approve_user')->nullable()->references('id')->on('users')->constrained();
            $table->foreignId('vendor_id')->constrained();
            $table->string('lot_number')->index();
            $table->string('facility_location');
            // $table->string('warehouse_location');
            $table->string('adjustment_type');
            $table->bigInteger('quantity');
            $table->string('uom');
            $table->date('expiration_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};

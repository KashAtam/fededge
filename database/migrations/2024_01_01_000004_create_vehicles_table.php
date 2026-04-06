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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique()->index();
            $table->string('vehicle_type'); // Car, Truck, Bus, Motorcycle, etc.
            $table->string('brand_model');
            $table->integer('year_of_manufacture');
            $table->string('vin')->nullable()->unique(); // Vehicle Identification Number
            $table->string('engine_number')->nullable();
            $table->string('color')->nullable();
            $table->decimal('engine_capacity', 5, 2)->nullable(); // in liters
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();

            $table->index('owner_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

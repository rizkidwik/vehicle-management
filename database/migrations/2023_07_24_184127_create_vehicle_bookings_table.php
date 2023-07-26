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
        Schema::create('vehicle_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id');
            $table->integer('driver_id');
            $table->date('booking_date');
            $table->string('status');
            $table->string('approval_1');
            $table->dateTime('approval_1_datetime');
            $table->string('approval_2');
            $table->dateTime('approval_2_datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_bookings');
    }
};

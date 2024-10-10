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
        Schema::create('seats', function (Blueprint $table) {
            $table->string('uid')->primary();             // Unique seat identifier (id) within the event.
            $table->string('label');           // Seat label (e.g., 'Table', 'Chair')
            $table->string('type');            // Seat type (table, chair, etc.)
            $table->boolean('booked')->default(false); // Whether the seat is booked or not
            $table->integer('x');              // X coordinate
            $table->integer('y');              // Y coordinate
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};

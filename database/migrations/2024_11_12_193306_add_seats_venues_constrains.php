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
//        Schema::table('seats', function ($table) {
//            $table->foreignId('venue_id')
//                ->constrained()
//                ->onDelete('cascade');
//        });
//
//        Schema::table('seats', function (Blueprint $table) {
//            $table->foreign('venue_id')
//                ->references('id')
//                ->on('venue')
//                ->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::table('role_user', function (Blueprint $table) {
//            $table->dropForeign(['role_id']);
//            $table->dropForeign(['user_id']);
//        });
    }
};

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
        Schema::table('bookings', function (Blueprint $table) {
            $table->double('ticket_price',8,2);
            $table->double('sub_total',8,2);
            $table->double('discount',8,2);
            $table->string('type');
            
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('ticket_price');
            $table->dropColumn('sub_total');
            $table->dropColumn('discount');
            $table->dropColumn('type');
            
           
        });
    }
};

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->text('description');
            $table->bigInteger('available_seat');
            $table->string('venue');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->float('ticket');
            // $table->string('banner');
            $table->boolean('is_approved');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

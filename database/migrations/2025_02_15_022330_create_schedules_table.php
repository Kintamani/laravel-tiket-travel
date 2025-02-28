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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_id')->constrained('locations')->onDelete('cascade');
            $table->dateTime('arrival_time');
            $table->foreignId('destination_id')->constrained('locations')->onDelete('cascade');
            $table->dateTime('departure_time');
            $table->text('description')->nullable();
            $table->integer('available_seats');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

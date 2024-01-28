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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->dateTime('date');
            $table->decimal('cost', 10, 2)->default(0);
            $table->integer('place_available');

            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')
            ->references('id')
            ->on('drivers')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};


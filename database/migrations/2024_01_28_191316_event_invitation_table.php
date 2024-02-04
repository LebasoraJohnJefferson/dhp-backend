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
        Schema::create('event_invitation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brgy_id');
            $table->unsignedBigInteger('event_id');
            $table->foreign('brgy_id')
                ->references('id')
                ->on('baranggay')
                ->onDelete('cascade');
            $table->foreign('event_id')
            ->references('id')
            ->on('event')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_invitation');
    }
};

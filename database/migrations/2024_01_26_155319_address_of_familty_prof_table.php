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
        Schema::create('family_profile_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bray_id');
            $table->unsignedBigInteger('FP_id');
            $table->foreign('bray_id')
                ->references('id')
                ->on('baranggay')
                ->onDelete('cascade');
            $table->foreign('FP_id')
                ->references('id')
                ->on('family_profile')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_profile_address');
    }
};

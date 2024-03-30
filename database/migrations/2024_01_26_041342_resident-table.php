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
        Schema::create('resident', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brgy_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable(true);
            $table->string('last_name');
            $table->string('suffix')->nullable(true);
            $table->string('sex');
            $table->string('civil_status');
            $table->string('occupation')->nullable(true);
            $table->date('birthday');
            $table->timestamps();
            $table->foreign('brgy_id')
                ->references('id')
                ->on('baranggay')
                ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident');
    }
};

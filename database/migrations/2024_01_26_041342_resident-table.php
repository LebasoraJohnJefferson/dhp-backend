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
            $table->string('mother_first_name');
            $table->string('mother_middle_name');
            $table->string('mother_last_name');
            $table->string('father_first_name');
            $table->string('father_middle_name');
            $table->string('father_last_name');
            $table->string('father_suffix')->nullable(true);
            $table->string('mother_citizenship');
            $table->string('father_citizenship');
            $table->string('mother_place_birth');
            $table->string('father_place_birth');
            $table->date('father_birthday');
            $table->date('mother_birthday');
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

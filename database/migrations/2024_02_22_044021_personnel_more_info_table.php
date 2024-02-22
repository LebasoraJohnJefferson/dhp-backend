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
        Schema::create('personnel_more_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('address');
            $table->date('birthday');
            $table->string('gender');
            $table->string('contact_number');
            $table->string('emergency_contact_relationship');
            $table->string('emergency_contact_number');
            $table->string('image')->nullable(true);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel_more_info');
    }
};

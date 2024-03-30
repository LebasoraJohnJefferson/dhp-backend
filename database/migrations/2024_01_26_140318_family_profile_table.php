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
        Schema::create('family_profile', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('father_id');
            $table->unsignedBigInteger('mother_id');
            $table->string('household_no');
            $table->string('contact_number');
            $table->string('occupation');
            $table->string('educ_attain');
            $table->string('food_prod_act');

            $table->string('toilet_type');
            $table->string('water_source');
            $table->boolean('using_iodized_salt');
            $table->boolean('using_IFR');
            $table->boolean('familty_planning');
            $table->boolean('mother_pregnant');
            $table->timestamps();

            $table->foreign('father_id')
                ->references('id')
                ->on('resident')
                ->onDelete('cascade');

            $table->foreign('mother_id')
                ->references('id')
                ->on('resident')
                ->onDelete('cascade');
            });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_profile');
    }
};

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
            $table->unsignedBigInteger('brgy_id')->nullable(true);
            $table->string('household_no');
            $table->string('father')->default('');
            $table->string('mother')->default('');
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

            $table->foreign('brgy_id')
                ->references('id')
                ->on('baranggay')
                ->onDelete('set null');
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

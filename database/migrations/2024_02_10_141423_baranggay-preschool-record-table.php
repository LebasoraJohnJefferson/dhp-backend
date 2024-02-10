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
        

        Schema::create('brgyPreschool', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('address');
            $table->string('indigenous_preschool_child');
            $table->float('weight', 8, 2);
            $table->float('height', 8, 2);
            $table->foreign('member_id')
                ->references('id')
                ->on('family_profile_members')
                ->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brgyPreschool');
    }
};

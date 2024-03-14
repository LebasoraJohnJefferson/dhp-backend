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
        Schema::create('family_profile_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id');
            $table->string('name');
            $table->date('birthDay');
            $table->string('gender');
            $table->string('relationship');
            $table->string('occupation')->nullable();
            $table->string('nursing_type')->nullable();
            $table->foreign('resident_id')
                ->references('id')
                ->on('resident')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_profile_members', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
        });

        Schema::dropIfExists('family_profile_members');
    }
};

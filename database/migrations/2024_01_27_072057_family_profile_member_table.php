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
            $table->unsignedBigInteger('fp_id');
            $table->unsignedBigInteger('resident_id');
            $table->string('relationship');
            $table->string('nursing_type')->nullable();
            $table->foreign('fp_id')
                ->references('id')
                ->on('family_profile')
                ->onDelete('cascade');
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
            $table->dropForeign(['fp_id']);
            $table->dropForeign(['resident_id']);
        });

        Schema::dropIfExists('family_profile_members');
    }
};

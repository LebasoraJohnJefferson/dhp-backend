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
        Schema::table('family_profile', function (Blueprint $table) {
            // Remove existing columns
            $table->dropColumn(['occupation', 'educ_attain']);

            // Add new columns
            $table->string('mother_occupation')->nullable(false);
            $table->string('father_occupation')->nullable(false);
            $table->string('mother_educ_attain')->after('father_occupation')->nullable(false);
            $table->string('father_educ_attain')->after('mother_educ_attain')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_profile', function (Blueprint $table) {
            $table->string('occupation');
            $table->string('educ_attain');

            $table->dropColumn([
                'mother_occupation',
                'father_occupation',
                'mother_educ_attain',
                'father_educ_attain',
            ]);
        });
    }
};

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
            $table->dropColumn('mother');
            $table->dropColumn('father');
            $table->string('mother_first_name')->nullable();
            $table->string('mother_middle_name')->nullable();
            $table->string('mother_last_name')->nullable();
            $table->string('mother_suffix')->nullable();

            $table->string('father_first_name')->nullable();
            $table->string('father_middle_name')->nullable();
            $table->string('father_last_name')->nullable();
            $table->string('father_suffix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_profile', function (Blueprint $table) {
            $table->string('mother');
            $table->string('father');
            $table->dropColumn('mother_first_name');
            $table->dropColumn('mother_middle_name');
            $table->dropColumn('mother_last_name');
            $table->dropColumn('mother_suffix');
            $table->dropColumn('father_first_name');
            $table->dropColumn('father_middle_name');
            $table->dropColumn('father_last_name');
            $table->dropColumn('father_suffix');
        });
    }
};

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
        });
    }
};

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
        Schema::table('baranggay', function (Blueprint $table) {
            $table->string('province')->nullable(true);
            $table->string('city')->nullable(true); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baranggay', function (Blueprint $table) {
            $table->dropColumn('province');
            $table->dropColumn('city');
        });
    }
};

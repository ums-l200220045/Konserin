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
        Schema::table('concerts', function (Blueprint $table) {
            Schema::table('concerts', function (Blueprint $table) {
                $table->dropColumn('date');
                $table->dateTime('start_date')->nullable()->after('venue');
                $table->dateTime('end_date')->nullable()->after('start_date');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concerts', function (Blueprint $table) {
            Schema::table('concerts', function (Blueprint $table) {
                $table->dropColumn(['start_date', 'end_date']);
                $table->dateTime('date')->nullable();
            });
        });
    }
};

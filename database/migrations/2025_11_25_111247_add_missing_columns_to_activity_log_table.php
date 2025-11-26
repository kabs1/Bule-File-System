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
        Schema::table('activity_log', function (Blueprint $table) {
            // Removed duplicate columns as they are already in 2025_11_24_090227_create_activity_log_table.php
            // $table->timestamp('date')->useCurrent()->after('id');
            // $table->string('note', 100)->after('date');
            // $table->string('module', 100)->after('note');
            // $table->string('type')->after('module');
            // $table->bigInteger('user_id')->after('type');
            // $table->bigInteger('branch_id')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            //
        });
    }
};

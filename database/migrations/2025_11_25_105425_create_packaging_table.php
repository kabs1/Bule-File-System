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
        Schema::create('packaging', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_id');
            $table->string('group_id');
            $table->integer('count')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('current_weight')->nullable();
            $table->string('remit_weight')->nullable();
            $table->string('loss_gain')->nullable();
            $table->string('sample')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('x_summary')->nullable();
            $table->string('s_summary')->nullable();
            $table->timestamp('date_recorded')->useCurrent();
            $table->timestamp('date_updated')->nullable()->useCurrentOnUpdate();
            $table->string('status')->nullable();
            $table->string('user_id');
            $table->string('stock_id');
            $table->string('branch_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packaging');
    }
};

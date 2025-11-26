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
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('wallet_id');
            $table->string('customer_id');
            $table->string('wallet_type')->nullable();
            $table->string('inwardmeltweight')->nullable();
            $table->date('date_recorded')->useCurrent();
            $table->date('date_updated')->nullable()->useCurrentOnUpdate();
            $table->string('status')->nullable();
            $table->string('user_id');
            $table->string('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};

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
        Schema::create('lot_management', function (Blueprint $table) {
            $table->bigIncrements('lot_id');
            $table->string('lot_code');
            $table->string('lot_description')->nullable();
            $table->timestamp('date_created')->useCurrent();
            $table->timestamp('date_updated')->nullable()->useCurrentOnUpdate();
            $table->integer('status')->default(1);
            $table->bigInteger('user_id');
            $table->bigInteger('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_management');
    }
};

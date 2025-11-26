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
        Schema::create('inward_management', function (Blueprint $table) {
            $table->bigIncrements('inward_id');
            $table->string('inward_code')->unique();
            $table->string('customer_id');
            $table->timestamp('date_created')->useCurrent();
            $table->timestamp('date_updated')->nullable()->useCurrentOnUpdate();
            $table->string('comments')->nullable();
            $table->bigInteger('status')->default(1);
            $table->bigInteger('user_id');
            $table->bigInteger('branch_id');
            $table->integer('lot_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inward_management');
    }
};

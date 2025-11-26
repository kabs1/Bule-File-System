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
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('branch_id');
            $table->string('branch_name', 200)->unique();
            $table->string('description', 200)->nullable();
            $table->timestamp('date_created')->useCurrent();
            $table->timestamp('date_updated')->nullable()->useCurrentOnUpdate();
            $table->bigInteger('user_id');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};

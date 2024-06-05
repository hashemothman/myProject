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
        Schema::create('max_amounts', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->enum('account_type', ['marketer','user', 'agent']);
            $table->integer('max_amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('max_amounts');
    }
};

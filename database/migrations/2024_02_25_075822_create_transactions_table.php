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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('transactionable'); // Adds transactionable_id and transactionable_type columns
            $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
            $table->integer('sender');
            $table->string('reciever_account');
            $table->decimal('amount');
            $table->enum('type', ['internal', 'external']);
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

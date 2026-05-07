<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('subscription_id');
            $table->integer('amount');
            $table->string('status');
            $table->string('provider');
            $table->string('transaction_reference')->unique();
            $table->timestamps();
        });

        DB::statement("
                ALTER TABLE payments 
                ADD CONSTRAINT payments_status_check 
                CHECK (status IN ('pending', 'completed', 'failed'))
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

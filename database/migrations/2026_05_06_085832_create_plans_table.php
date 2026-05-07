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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('price');
            $table->string('billing_interval');
            $table->integer('trial_days');
            $table->timestamps();
        });

        DB::statement("
                ALTER TABLE plans 
                ADD CONSTRAINT plans_billing_interval_check 
                CHECK (billing_interval IN ('monthly', 'yearly', 'one_time'))
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

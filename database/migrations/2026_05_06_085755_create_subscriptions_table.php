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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_start');
            $table->timestamp('current_period_end')->nullable();
            $table->integer('retry_count');
            $table->timestamp('next_retry_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });

        DB::statement("
                ALTER TABLE subscriptions 
                ADD CONSTRAINT subscriptions_status_check 
                CHECK (status IN ('trialing', 'active', 'past_due', 'cancelled', 'expired'))
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

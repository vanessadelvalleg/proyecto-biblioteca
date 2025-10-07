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
    Schema::create('subscriptions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('plan_name'); // 'basic', 'premium'
        $table->string('status');    // 'active', 'cancelled', 'past_due'

        $table->timestamp('starts_at')->useCurrent();
        $table->timestamp('ends_at')->nullable();

        $table->string('stripe_subscription_id')->nullable();
        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

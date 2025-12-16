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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'backer_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Tier::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount');
            $table->boolean('refunded')->default(false);
            $table->timestamp('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

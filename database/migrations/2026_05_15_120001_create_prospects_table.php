<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('source')->default('web');
            $table->string('status')->default('new');
            $table->text('interest')->nullable();
            $table->string('budget_range')->nullable();
            $table->unsignedSmallInteger('score')->default(0);
            $table->string('chatbot_conversation_id')->nullable();
            $table->json('chatbot_payload')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('next_follow_up_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->string('lost_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'assigned_to']);
            $table->index(['status', 'next_follow_up_at']);
            $table->index('source');
            $table->index('phone');
            $table->index('chatbot_conversation_id');
            $table->index('score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prospects');
    }
};

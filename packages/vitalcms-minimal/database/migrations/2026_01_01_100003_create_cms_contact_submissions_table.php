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
        $tableName = config('vitalcms.table_prefix', 'cms_') . 'contact_submissions';

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->string('service_interest')->nullable(); // Which service they're interested in
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->enum('status', ['new', 'read', 'replied', 'archived'])->default('new');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->longText('notes')->nullable(); // Admin notes
            $table->timestamps();

            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['email', 'created_at']);
            $table->index('service_interest');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = config('vitalcms.table_prefix', 'cms_') . 'contact_submissions';
        Schema::dropIfExists($tableName);
    }
};
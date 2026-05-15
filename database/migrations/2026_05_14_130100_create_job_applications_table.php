<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_vacancy_id')->nullable()->constrained('job_vacancies')->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('position_interest')->nullable();
            $table->text('message')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('status')->default('nuevo');
            $table->text('internal_notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('job_vacancy_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};

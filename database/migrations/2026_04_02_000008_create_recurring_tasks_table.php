<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('recurring_tasks')) {
            return;
        }

        Schema::connection('mongodb')->create('recurring_tasks', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('task_name');
            $table->string('frequency')->default('daily');
            $table->json('meta')->nullable();
            $table->boolean('is_active')->default(true);
            $table->dateTime('next_run_at')->nullable();
            $table->dateTime('last_ran_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'school_id']);
            $table->index('frequency');
            $table->index('is_active');
            $table->index('next_run_at');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('recurring_tasks');
    }
};

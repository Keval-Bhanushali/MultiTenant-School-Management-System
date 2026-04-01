<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('schedules')) {
            return;
        }

        Schema::connection('mongodb')->create('schedules', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('name');
            $table->dateTime('date');
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'school_id']);
            $table->index('status');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('schedules');
    }
};

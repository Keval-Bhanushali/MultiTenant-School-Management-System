<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('transactions')) {
            return;
        }

        Schema::connection('mongodb')->create('transactions', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('wallet_id');
            $table->string('student_user_id')->nullable();
            $table->string('type');
            $table->decimal('amount', 12, 2);
            $table->string('reference')->nullable();
            $table->string('method')->nullable();
            $table->string('channel')->nullable();
            $table->string('status')->default('success');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'school_id']);
            $table->index('wallet_id');
            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('transactions');
    }
};

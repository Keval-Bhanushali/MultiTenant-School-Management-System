<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('wallets')) {
            return;
        }

        Schema::connection('mongodb')->create('wallets', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('user_id');
            $table->string('parent_user_id')->nullable();
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('currency')->default('INR');
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['tenant_id', 'school_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('wallets');
    }
};

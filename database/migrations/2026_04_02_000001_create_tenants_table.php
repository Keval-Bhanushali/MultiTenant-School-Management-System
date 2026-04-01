<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('tenants')) {
            return;
        }

        Schema::connection('mongodb')->create('tenants', function (Blueprint $table) {
            $table->string('domain')->unique();
            $table->string('name');
            $table->json('settings')->nullable();
            $table->string('subscription_plan')->default('starter');
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index('subscription_plan');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('tenants');
    }
};

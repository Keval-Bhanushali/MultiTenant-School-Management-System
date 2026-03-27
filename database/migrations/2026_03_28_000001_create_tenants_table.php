<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();
            $table->string('name');
            $table->json('settings')->nullable();
            $table->string('subscription_plan');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};

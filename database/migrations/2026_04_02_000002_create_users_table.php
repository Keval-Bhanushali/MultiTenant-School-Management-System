<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('users')) {
            return;
        }

        Schema::connection('mongodb')->create('users', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->unsignedTinyInteger('role_id')->default(5);
            $table->string('role')->default('student');
            $table->string('school_id')->nullable();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('preferred_language')->default('en');
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamps();

            $table->index('tenant_id');
            $table->index('school_id');
            $table->index('role_id');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('users');
    }
};

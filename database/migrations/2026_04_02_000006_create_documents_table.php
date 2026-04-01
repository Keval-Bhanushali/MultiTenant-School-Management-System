<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('documents')) {
            return;
        }

        Schema::connection('mongodb')->create('documents', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('user_id');
            $table->string('type');
            $table->string('file_path');
            $table->string('status')->default('uploaded');
            $table->string('verified_by')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'school_id']);
            $table->index('user_id');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('documents');
    }
};

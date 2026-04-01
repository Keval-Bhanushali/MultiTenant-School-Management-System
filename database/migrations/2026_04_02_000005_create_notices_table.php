<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('mongodb')->hasTable('notices')) {
            return;
        }

        Schema::connection('mongodb')->create('notices', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('noticeable_type')->nullable();
            $table->string('noticeable_id')->nullable();
            $table->string('title');
            $table->text('message');
            $table->string('target_role')->default('all');
            $table->string('target_locale')->default('en');
            $table->json('translated_messages')->nullable();
            $table->string('scope')->default('school');
            $table->dateTime('publish_at')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'school_id']);
            $table->index(['noticeable_type', 'noticeable_id']);
            $table->index('scope');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('notices');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['aadhaar_card', 'pan_card', 'marksheet']);
            $table->string('file_path');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

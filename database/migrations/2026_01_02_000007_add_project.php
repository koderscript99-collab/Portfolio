<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('language'); // e.g. Python, Node.js, PHP
            $table->date('expiry_date')->nullable(); // db/hosting expiry
            $table->string('host_type')->nullable(); // e.g. Shared, VPS, Cloud
            $table->string('host_provider')->nullable(); // e.g. Hostinger, DigitalOcean
            $table->string('url')->nullable();
            $table->enum('status', ['started', 'in_progress', 'done'])->default('started');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
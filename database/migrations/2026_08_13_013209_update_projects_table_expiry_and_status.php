<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['expiry_date', 'status']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->date('hosting_expiry_date')->nullable()->after('language');
            $table->date('database_expiry_date')->nullable()->after('hosting_expiry_date');
            $table->enum('status', ['raw', 'processing', 'finished'])->default('raw')->after('url');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['hosting_expiry_date', 'database_expiry_date', 'status']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['started', 'in_progress', 'done'])->default('started');
        });
    }
};
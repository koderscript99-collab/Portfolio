<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('projects', 'status')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        if (! Schema::hasColumn('projects', 'progress')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->unsignedTinyInteger('progress')->default(0)->after('url');
            });
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('progress');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', ['raw', 'processing', 'finished'])->default('raw');
        });
    }
};
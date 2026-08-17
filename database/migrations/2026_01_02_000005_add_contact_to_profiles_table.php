<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Digits only, no + or spaces — e.g. 2348012345678
            $table->string('support_whatsapp')->nullable()->after('social_links');
            $table->string('support_email')->nullable()->after('support_whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['support_whatsapp', 'support_email']);
        });
    }
};
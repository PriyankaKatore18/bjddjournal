<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->timestamp('status_email_sent_at')->nullable()->after('email_error');
            $table->longText('status_email_error')->nullable()->after('status_email_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->dropColumn(['status_email_sent_at', 'status_email_error']);
        });
    }
};

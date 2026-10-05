<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->string('paper_id')->nullable()->unique()->after('id');
            $table->string('previous_paper_id')->nullable()->after('paper_id');
            $table->string('plagiarism_report_path')->nullable()->after('file_path');
            $table->string('ai_report_path')->nullable()->after('plagiarism_report_path');
            $table->boolean('originality_declaration')->default(false)->after('pincode');
            $table->boolean('authorship_consent')->default(false)->after('originality_declaration');
            $table->boolean('ethics_declaration')->default(false)->after('authorship_consent');
            $table->boolean('journal_policies')->default(false)->after('ethics_declaration');
            $table->boolean('final_confirmation')->default(false)->after('journal_policies');
            $table->uuid('submission_token')->nullable()->unique()->after('final_confirmation');
            $table->timestamp('submitted_at')->nullable()->after('status');
            $table->timestamp('email_sent_at')->nullable()->after('submitted_at');
            $table->text('email_error')->nullable()->after('email_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->dropUnique(['paper_id']);
            $table->dropUnique(['submission_token']);
            $table->dropColumn([
                'paper_id',
                'previous_paper_id',
                'plagiarism_report_path',
                'ai_report_path',
                'originality_declaration',
                'authorship_consent',
                'ethics_declaration',
                'journal_policies',
                'final_confirmation',
                'submission_token',
                'submitted_at',
                'email_sent_at',
                'email_error',
            ]);
        });
    }
};

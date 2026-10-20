<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->foreignId('special_issue_id')
                ->nullable()
                ->after('id')
                ->constrained('special_issues')
                ->nullOnDelete();

            $table->index(['special_issue_id', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->dropForeign(['special_issue_id']);
            $table->dropIndex(['special_issue_id', 'submitted_at']);
            $table->dropColumn('special_issue_id');
        });
    }
};

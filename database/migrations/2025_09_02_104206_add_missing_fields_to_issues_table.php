<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            if (!Schema::hasColumn('issues', 'registration_id')) {
                $table->string('registration_id')->nullable()->after('publish_date');
            }
            if (!Schema::hasColumn('issues', 'published_paper_id')) {
                $table->string('published_paper_id')->nullable()->after('registration_id');
            }
            if (!Schema::hasColumn('issues', 'year')) {
                $table->string('year')->nullable()->after('published_paper_id');
            }
            if (!Schema::hasColumn('issues', 'approved_eissn')) {
                $table->string('approved_eissn')->nullable()->after('year');
            }
            if (!Schema::hasColumn('issues', 'country')) {
                $table->string('country')->nullable()->after('approved_eissn');
            }
            if (!Schema::hasColumn('issues', 'crossref_doi_member_id')) {
                $table->string('crossref_doi_member_id')->nullable()->after('country');
            }
            if (!Schema::hasColumn('issues', 'page_no')) {
                $table->string('page_no')->nullable()->after('crossref_doi_member_id');
            }
            if (!Schema::hasColumn('issues', 'downloads_count')) {
                $table->integer('downloads_count')->default(0)->after('page_no');
            }
            if (!Schema::hasColumn('issues', 'published_paper_url')) {
                $table->string('published_paper_url')->nullable()->after('downloads_count');
            }
            if (!Schema::hasColumn('issues', 'published_paper_pdf')) {
                $table->string('published_paper_pdf')->nullable()->after('published_paper_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn([
                'registration_id',
                'published_paper_id',
                'year',
                'approved_eissn',
                'country',
                'crossref_doi_member_id',
                'page_no',
                'downloads_count',
                'published_paper_url',
                'published_paper_pdf'
            ]);
        });
    }
};
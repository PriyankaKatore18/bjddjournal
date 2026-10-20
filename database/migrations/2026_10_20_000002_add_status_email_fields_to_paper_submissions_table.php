<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->longText('editorial_remarks')->nullable()->after('status');
            $table->decimal('publication_fee', 10, 2)->nullable()->after('editorial_remarks');
            $table->string('payment_link', 2048)->nullable()->after('publication_fee');
            $table->string('article_url', 2048)->nullable()->after('payment_link');
        });
    }

    public function down(): void
    {
        Schema::table('paper_submissions', function (Blueprint $table) {
            $table->dropColumn(['editorial_remarks', 'publication_fee', 'payment_link', 'article_url']);
        });
    }
};

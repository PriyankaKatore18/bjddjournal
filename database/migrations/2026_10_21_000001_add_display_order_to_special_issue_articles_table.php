<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('special_issue_articles', function (Blueprint $table) {
            $table->unsignedInteger('display_order')->default(0)->after('status');
        });

        $issueIds = DB::table('special_issue_articles')
            ->select('special_issue_id')
            ->distinct()
            ->pluck('special_issue_id');

        foreach ($issueIds as $issueId) {
            $order = 1;

            DB::table('special_issue_articles')
                ->where('special_issue_id', $issueId)
                ->orderByDesc('published_date')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get(['id'])
                ->each(function ($article) use (&$order) {
                    DB::table('special_issue_articles')
                        ->where('id', $article->id)
                        ->update(['display_order' => $order++]);
                });
        }
    }

    public function down(): void
    {
        Schema::table('special_issue_articles', function (Blueprint $table) {
            $table->dropColumn('display_order');
        });
    }
};

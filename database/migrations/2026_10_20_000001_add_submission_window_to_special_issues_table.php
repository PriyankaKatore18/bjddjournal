<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('special_issues', function (Blueprint $table) {
            $table->boolean('submission_open')->default(true)->after('status');
            $table->date('submission_deadline')->nullable()->after('submission_open');
        });
    }

    public function down(): void
    {
        Schema::table('special_issues', function (Blueprint $table) {
            $table->dropColumn(['submission_open', 'submission_deadline']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('publications')) {
            return;
        }

        if (! Schema::hasColumn('publications', 'view_count')) {
            Schema::table('publications', function (Blueprint $table) {
                $table->unsignedInteger('view_count')->default(0)->after('download_count');
            });
        }

        foreach (['received_at', 'revised_at', 'accepted_at', 'published_online_at'] as $column) {
            if (! Schema::hasColumn('publications', $column)) {
                Schema::table('publications', function (Blueprint $table) use ($column) {
                    $table->date($column)->nullable()->after('view_count');
                });
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('publications')) {
            return;
        }

        $columns = array_values(array_filter(
            ['view_count', 'received_at', 'revised_at', 'accepted_at', 'published_online_at'],
            fn (string $column) => Schema::hasColumn('publications', $column)
        ));

        if ($columns) {
            Schema::table('publications', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};

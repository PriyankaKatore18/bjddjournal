<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('visitor_counters')) {
            return;
        }

        if (! Schema::hasColumn('visitor_counters', 'today_visits')) {
            Schema::table('visitor_counters', function (Blueprint $table) {
                $table->unsignedBigInteger('today_visits')->default(0)->after('total_visits');
            });
        }

        if (! Schema::hasColumn('visitor_counters', 'visit_date')) {
            Schema::table('visitor_counters', function (Blueprint $table) {
                $table->date('visit_date')->nullable()->after('today_visits');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('visitor_counters')) {
            return;
        }

        $columns = array_values(array_filter(
            ['today_visits', 'visit_date'],
            fn (string $column) => Schema::hasColumn('visitor_counters', $column)
        ));

        if ($columns) {
            Schema::table('visitor_counters', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};

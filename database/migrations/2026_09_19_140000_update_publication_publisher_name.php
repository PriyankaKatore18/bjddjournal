<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('publications') || ! Schema::hasColumn('publications', 'publisher')) {
            return;
        }

        DB::table('publications')
            ->whereRaw('LOWER(TRIM(publisher)) = ?', ['bodhivruksha publication'])
            ->update(['publisher' => 'Eagle Leap Publication']);
    }

    public function down(): void
    {
        // This is a data-correction migration and should not restore the old publisher name.
    }
};

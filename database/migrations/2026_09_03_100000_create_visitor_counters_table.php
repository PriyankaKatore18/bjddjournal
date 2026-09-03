<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('visitor_counters')) {
            Schema::create('visitor_counters', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('total_visits')->default(0);
                $table->timestamps();
            });
        }

        if (! DB::table('visitor_counters')->where('id', 1)->exists()) {
            DB::table('visitor_counters')->insert([
                'id' => 1,
                'total_visits' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_counters');
    }
};

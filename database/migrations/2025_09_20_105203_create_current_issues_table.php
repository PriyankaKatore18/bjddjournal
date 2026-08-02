<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('current_issues')) {
            Schema::create('current_issues', function (Blueprint $table) {
                $table->id();
                $table->string('volume');
                $table->string('issue');
                $table->string('month_year');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
            
            // Insert a default record
            DB::table('current_issues')->insert([
                'volume' => '1',
                'issue' => '3',
                'month_year' => 'September – October 2025',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_issues');
    }
};
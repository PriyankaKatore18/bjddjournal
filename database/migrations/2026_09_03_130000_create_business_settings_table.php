<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('business_settings')) {
            Schema::create('business_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->index();
                $table->longText('value')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // This table may already exist on live sites and is shared by Home/Archive settings.
    }
};

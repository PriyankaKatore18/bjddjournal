<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('special_issues', function (Blueprint $table) {
            $table->id();
            $table->string('special_issue_id')->unique();
            $table->string('type')->default('Conference Special Issue');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('institution')->nullable();
            $table->string('department')->nullable();
            $table->date('conference_date')->nullable();
            $table->string('mode')->nullable();
            $table->string('status')->default('draft');
            $table->string('cover_image')->nullable();
            $table->longText('about_conference')->nullable();
            $table->longText('editorial_details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('special_issues');
    }
};

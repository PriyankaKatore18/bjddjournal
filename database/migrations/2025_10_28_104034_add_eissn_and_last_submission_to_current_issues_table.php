<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('current_issues', function (Blueprint $table) {
            $table->string('e_issn')->default('Applied / Under Process')->after('month_year');
            $table->date('last_submission_date')->nullable()->after('e_issn');
        });
    }

    public function down()
    {
        Schema::table('current_issues', function (Blueprint $table) {
            $table->dropColumn(['e_issn', 'last_submission_date']);
        });
    }
};
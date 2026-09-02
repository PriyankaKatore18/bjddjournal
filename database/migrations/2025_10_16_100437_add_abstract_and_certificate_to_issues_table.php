<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->text('abstract')->nullable()->after('title');
            $table->string('paper_certificate')->nullable()->after('published_paper_pdf');
        });
    }

    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn(['abstract', 'paper_certificate']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('paper_title');
            $table->string('author_name');
            $table->string('registration_id')->nullable();
            $table->string('published_paper_id')->nullable();
            $table->integer('year');
            $table->integer('volume');
            $table->integer('issue');
            $table->string('issue_range')->nullable();
            $table->string('eissn')->nullable();
            $table->string('country')->nullable();
            $table->string('crossref_doi')->nullable();
            $table->string('page_nos')->nullable();
            $table->integer('download_count')->default(0);
            $table->string('paper_url')->nullable();
            $table->string('paper_pdf')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publications');
    }
};
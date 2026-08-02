<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paper_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_path');
            $table->string('research_area');
            $table->string('author_main_name');
            $table->string('author_main_designation');
            $table->string('author_main_institute');
            $table->string('author_main_email');
            $table->string('author_main_mobile');
            $table->json('co_authors')->nullable();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode');
            $table->string('status')->default('submitted');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paper_submissions');
    }
};

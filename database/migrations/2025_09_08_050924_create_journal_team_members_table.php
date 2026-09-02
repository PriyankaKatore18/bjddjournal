<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('journal_team_members', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['chief_editor', 'editor', 'reviewer']);
            $table->string('name');
            $table->string('position');
            $table->string('department');
            $table->string('institution');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('qualification')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_team_members');
    }
};
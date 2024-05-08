<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gitlab_id')->index();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('noteable_id')->index();
            $table->unsignedBigInteger('project_id')->index();

            $table->boolean('system');

            $table->string('noteable_type')->index();
            $table->text('body');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

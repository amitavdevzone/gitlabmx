<?php

use App\Enums\IssueStateEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gitlab_id');
            $table->unsignedBigInteger('internal_id')->index();
            $table->unsignedBigInteger('project_id')->index();
            $table->unsignedBigInteger('author_id')->index();
            $table->unsignedBigInteger('assigned_to')->index();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('state')->default(IssueStateEnum::OPENED)->index();
            $table->timestamp('closed_at')->nullable();
            $table->json('labels');
            $table->json('assignees');
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};

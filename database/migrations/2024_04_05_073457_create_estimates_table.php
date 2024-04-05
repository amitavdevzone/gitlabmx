<?php

use App\Models\Delivery;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)->index();
            $table->foreignIdFor(Delivery::class)->index();
            $table->string('title');
            $table->text('description');
            $table->boolean('is_complete')->default(0)->index();
            $table->unsignedInteger('progress_percentage')->default(0);
            $table->unsignedInteger('estimated_hours')->default(0);
            $table->unsignedInteger('completed_hours')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};

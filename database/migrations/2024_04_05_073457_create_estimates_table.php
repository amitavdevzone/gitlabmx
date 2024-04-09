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
            $table->float('progress_percentage', 2)->default(0);
            $table->float('estimated_hours', 2)->default(0);
            $table->float('completed_hours', 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};

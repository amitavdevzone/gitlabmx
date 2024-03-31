<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)->index();
            $table->foreignIdFor(User::class, 'owner_id');
            $table->string('title');
            $table->longText('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_complete')->index()->default(0);
            $table->unsignedBigInteger('progress_complete')->default(0);
            $table->unsignedBigInteger('estimated_hours')->default(0);
            $table->unsignedBigInteger('completed_hours')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};

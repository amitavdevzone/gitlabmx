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
            $table->float('progress_complete', 2)->default(0);
            $table->float('estimated_hours', 2)->default(0);
            $table->float('completed_hours', 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};

<?php

use App\Models\Client;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->index();
            $table->foreignIdFor(Client::class)->index();
            $table->foreignIdFor(Project::class)->index();
            $table->foreignIdFor(Issue::class)->index()->nullable();

            $table->string('description');
            $table->unsignedBigInteger('time');
            $table->boolean('is_backdate')->default(false);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};

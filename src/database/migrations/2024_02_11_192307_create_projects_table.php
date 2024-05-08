<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->index();
            $table->foreignIdFor(Client::class)->index()->nullable();

            $table->string('name');
            $table->string('name_with_namespace');
            $table->text('description')->nullable();
            $table->string('web_url')->nullable();
            $table->string('visibility');

            $table->timestamp('project_created_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};

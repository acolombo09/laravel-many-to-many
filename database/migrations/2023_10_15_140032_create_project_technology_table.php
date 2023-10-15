<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_technology', function (Blueprint $table) {

            // creo FKey projects
            $table->unsignedBigInteger('project_id');
            // rendo la colonna project_id una FK
            $table->foreign('project_id')
                // riferito alla colonna id
                ->references('id')
                // nella tabella projects
                ->on('projects');

            // creo FKey technologies
            $table->unsignedBigInteger('technology_id');
            // rendo la colonna technology_id una FK
            $table->foreign('technology_id')
                // riferito alla colonna id
                ->references('id')
                // nella tabella technologys
                ->on('technologies');

            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};

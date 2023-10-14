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
        Schema::table('projects', function (Blueprint $table) {
            // creo id riferito alla table types
            $table->unsignedBigInteger("type_id")->nullable()->after("id");

            // rendo la colonna type_id una FK
            $table->foreign("type_id")
                // riferito alla colonna id
                ->references("id")
                // nella tabella types
                ->on("types");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // processo inverso, rimuovo la foreign key nella table projects tramite id
            $table->dropForeign("projects_type_id_foreign");

            // e rimuovo la colonna type_id
            $table->dropColumn("type_id");
        });
    }
};

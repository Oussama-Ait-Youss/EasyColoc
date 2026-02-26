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
    Schema::table('memberships', function (Blueprint $table) {
        // On ajoute la colonne reputation qui manquait
        $table->integer('reputation')->default(100)->after('role');
    });
}

public function down(): void
{
    Schema::table('memberships', function (Blueprint $table) {
        $table->dropColumn('reputation');
    });
}
};

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
    	//
    	Schema::table('offices', static function (Blueprint $table) {
    		$table->boolean('is_forgiven')->default(false)->after('order')->comment('Is (default false) the Persona credited Dues while holding this Office?');
    		$table->boolean('is_midreign')->default(false)->after('is_forgiven')->comment('Is (default false) the Office held between midreigns?');
    	});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    	Schema::table('offices', static function (Blueprint $table) {
    		$table->dropColumn('is_forgiven');
    		$table->dropColumn('is_midreign');
    	});
    }
};

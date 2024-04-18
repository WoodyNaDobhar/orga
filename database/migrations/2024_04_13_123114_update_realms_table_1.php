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
    	Schema::table('realms', static function (Blueprint $table) {
    		$table->unsignedSmallInteger('waiver_duration')->nullable()->after('dues_take')->comment('Length of time in months a Realm considers a Waiver valid.');
    	});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    	Schema::table('realms', static function (Blueprint $table) {
    		$table->dropColumn('waiver_duration');
    	});
    }
};

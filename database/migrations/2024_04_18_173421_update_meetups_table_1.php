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
    	Schema::table('meetups', static function (Blueprint $table) {
    		$table->string('name', 50)->after('location_id')->comment('Meetup label');
    	});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    	Schema::table('meetups', static function (Blueprint $table) {
    		$table->dropColumn('name');
    	});
    }
};

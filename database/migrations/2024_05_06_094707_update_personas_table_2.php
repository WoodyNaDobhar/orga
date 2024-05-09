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
		Schema::table('personas', static function (Blueprint $table) {
			$table->string('slug', 25)->after('name')->nullable()->comment('A unique URL appropriate string used to access the profile.  These are first-come first serve.  Honorifics are fine here.  Communitiy standards and the terms of use for the site are to be followed.');
		});
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('personas', static function (Blueprint $table) {
			$table->dropColumn('slug');
		});
	}
};

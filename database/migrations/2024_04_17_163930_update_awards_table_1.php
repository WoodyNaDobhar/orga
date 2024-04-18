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
		Schema::table('awards', static function (Blueprint $table) {
			$table->boolean('is_active')->after('name')->default(true)->comment('Is (default true) this Award still being given out?');
		});
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('awards', static function (Blueprint $table) {
			$table->dropColumn('is_active');
		});
	}
};

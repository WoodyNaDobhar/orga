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
		Schema::table('issuances', static function (Blueprint $table) {
			$table->unsignedBigInteger('parent_id')->nullable()->index('parent_id')->after('rank')->comment('For Persona Title Issuances, The ID of the Title Issuance from which this Issuance was given.');
		});
			
		Schema::table('issuances', function (Blueprint $table) {
			$table->foreign(['parent_id'], 'issuances_parent_id')->references(['id'])->on('issuances')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
	
	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		
		Schema::table('issuances', function (Blueprint $table) {
			$table->dropForeign('issuances_parent_id');
		});
			
		Schema::table('issuances', static function (Blueprint $table) {
			$table->dropColumn('parent_id');
		});
	}
};

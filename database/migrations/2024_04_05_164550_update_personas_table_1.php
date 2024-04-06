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
			$table->unsignedBigInteger('honorific_id')->nullable()->index('honorific_id')->after('pronoun_id')->comment('The ID of the Title Issuance the Persona considers primary of the Titles they have');
		});
			
		Schema::table('personas', function (Blueprint $table) {
			$table->foreign(['honorific_id'], 'personas_honorific_id')->references(['id'])->on('issuances')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		
		Schema::table('personas', function (Blueprint $table) {
			$table->dropForeign('personas_honorific_id');
		});
		
		Schema::table('personas', static function (Blueprint $table) {
			$table->dropColumn('honorific_id');
		});
	}
};

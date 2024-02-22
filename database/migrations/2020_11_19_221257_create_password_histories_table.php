<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordHistoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();
		Schema::create('password_histories', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('user_id')->index('user_id');
			$table->string('password');
			$table->timestamp('created_at')->useCurrent();
		});
		Schema::table('password_histories', function(Blueprint $table)
		{
			$table->foreign('user_id', 'password_history_user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
		Schema::enableForeignKeyConstraints();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::disableForeignKeyConstraints();
		Schema::table('password_histories', function(Blueprint $table)
		{
			$table->dropForeign('password_history_user_id');
		});
		Schema::dropIfExists('password_histories');
		Schema::enableForeignKeyConstraints();
	}
}

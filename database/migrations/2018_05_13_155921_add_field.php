<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddField extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::table('users',
			function (Blueprint $table) {
				$table->boolean('active')->default(false);
				$table->string('token')->nullable();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		//
	}
}

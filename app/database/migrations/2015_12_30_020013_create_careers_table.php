<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('careers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('code');
			$table->string('name');
			$table->timestamps();
		});

		Schema::table('users', function($table){
			$table->integer('career_id')->unsigned()->nullable();
			$table->foreign('career_id')->references('id')->on('careers')->onDelete('set null');
		});

		Schema::table('tags', function($table){
			$table->integer('career_id')->unsigned()->nullable();
			$table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('careers');
	}

}

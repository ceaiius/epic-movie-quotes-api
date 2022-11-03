<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movies', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->references('id')->on('users')
			->onDelete('cascade');
			$table->json('name')->nullable();
			$table->json('director')->nullable();
			$table->json('description')->nullable();
			$table->string('genre');
			$table->string('year');
			$table->string('budget');
			$table->string('thumbnail')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('movies');
	}
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(config('mail-viewer.table'), function (Blueprint $table) {
			$table->increments('id');

			$table->string('from')->nullable();
			$table->string('to')->nullable();
			$table->string('cc')->nullable();
			$table->string('bcc')->nullable();
			$table->string('subject');
			$table->text('body');
			$table->text('headers')->nullable();
			$table->text('attachments')->nullable();

			$table->timestamp('date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('mail_logs');
	}
}

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMailLogsTable
 */
class CreateMailLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create((string)config('mail-viewer.table', 'mail_logs'), function (Blueprint $table) {
			$table->increments('id');

			$table->json('from')->nullable();
			$table->json('to')->nullable();
			$table->json('cc')->nullable();
			$table->json('bcc')->nullable();
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

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

			$table->jsonb('from')->nullable();
			$table->jsonb('to')->nullable();
			$table->jsonb('cc')->nullable();
			$table->jsonb('bcc')->nullable();
			$table->string('subject');
			$table->text('body');
			$table->jsonb('headers')->nullable();
			$table->jsonb('attachments')->nullable();
            $table->longText('payload')->nullable();

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

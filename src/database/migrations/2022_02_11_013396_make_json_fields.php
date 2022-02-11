<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::table(config('mail-viewer.table', 'mail_logs'))
            ->latest('date')
            ->each(function (stdClass $mail) {
                try {
                    DB::table(config('mail-viewer.table', 'mail_logs'))
                        ->where('id', $mail->id)
                        ->update([
                            'attachments' => explode('\n\n', $mail->attachments),
                            'headers'     => explode('\n\n', $mail->headers),
                        ]);
                } catch (Throwable $t) {
                    //
                }
            });

        Schema::table((string) config('mail-viewer.table', 'mail_logs'), function (Blueprint $table) {
            $table->json('attachments')->change();
            $table->json('headers')->change();
        });
    }

    public function down()
    {
        Schema::table((string) config('mail-viewer.table', 'mail_logs'), function (Blueprint $table) {
            $table->text('attachments')->change();
            $table->text('headers')->change();
        });
    }
};
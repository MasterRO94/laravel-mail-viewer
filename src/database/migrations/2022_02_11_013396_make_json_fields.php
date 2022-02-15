<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {

    public function up(): void
    {
        $table = config('mail-viewer.table', 'mail_logs');

        DB::table($table)
            ->latest('date')
            ->each(function (stdClass $mail) use ($table) {
                try {
                    DB::table($table)
                        ->where('id', $mail->id)
                        ->update([
                            'attachments' => collect(preg_split('/(\\n\\n|\\r\\n)/', $mail->attachments))
                                ->filter()
                                ->toArray(),
                            'headers'     => collect(preg_split('/(\\n\\n|\\r\\n)/', $mail->headers))
                                ->mapWithKeys(fn(string $header) => [
                                    Str::before($header, ':') => Str::after($header, ':'),
                                ])
                                ->filter()
                                ->toArray(),
                        ]);
                } catch (Throwable $t) {
                    //
                }
            });

        Schema::table($table, function (Blueprint $table) {
            $table->json('attachments')->change();
            $table->json('headers')->change();
        });
    }

    public function down(): void
    {
        Schema::table((string) config('mail-viewer.table', 'mail_logs'), function (Blueprint $table) {
            $table->text('attachments')->change();
            $table->text('headers')->change();
        });
    }
};
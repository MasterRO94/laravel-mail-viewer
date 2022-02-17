<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table((string) config('mail-viewer.table', 'mail_logs'), function (Blueprint $table) {
            $table->longText('payload')->after('attachments')->default('');
        });
    }

    public function down(): void
    {
        Schema::table((string) config('mail-viewer.table', 'mail_logs'), function (Blueprint $table) {
            $table->dropColumn('payload');
        });
    }
};
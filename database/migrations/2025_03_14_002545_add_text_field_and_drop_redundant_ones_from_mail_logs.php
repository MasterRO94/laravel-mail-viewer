<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mail_logs', function (Blueprint $table) {
            $table->dropColumn([
                'from',
                'to',
                'cc',
                'bcc',
            ]);

            $table->longText('body')->nullable()->change();
            $table->text('text')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('mail_logs', function (Blueprint $table) {
            $table->jsonb('from')->nullable();
            $table->jsonb('to')->nullable();
            $table->jsonb('cc')->nullable();
            $table->jsonb('bcc')->nullable();
            $table->dropColumn('text');
        });
    }
};

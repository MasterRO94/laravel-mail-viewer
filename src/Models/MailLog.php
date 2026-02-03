<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use MasterRO\MailViewer\Services\AddressParser;

class MailLog extends Model
{
    use MassPrunable;

    protected static $unguarded = true;

    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime',
        'headers' => 'array',
        'attachments' => 'array',
    ];

    protected $appends = [
        'to',
        'cc',
        'bcc',
        'from',
        'formattedDate',
        'formattedTime',
    ];

    protected $attributes = [
        'payload' => '',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('mail-viewer.table', 'mail_logs'));
        $this->setConnection(config('mail-viewer.connection', config('database.default')));
    }

    public function prunable(): Builder
    {
        $pruneOlderThanDays = (int) config('mail-viewer.prune_older_than_days');

        return $pruneOlderThanDays > 0
            ? static::where('date', '<', today()->subDays($pruneOlderThanDays))
            : static::where('id', 0);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query
            ->where('subject', 'like', "%$term%")
            ->orWhere('headers', 'like', "%$term%");
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->date
            ->tz(config('mail-viewer.timezone', config('app.timezone', 'UTC')))
            ->format(config('mail-viewer.date_format'));
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->date
            ->tz(config('mail-viewer.timezone', config('app.timezone', 'UTC')))
            ->format(config('mail-viewer.time_format'));
    }

    public function to(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getAddressable('To'),
        )->shouldCache();
    }

    public function from(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getAddressable('From'),
        )->shouldCache();
    }

    public function cc(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getAddressable('Cc'),
        )->shouldCache();
    }

    public function bcc(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getAddressable('Bcc'),
        )->shouldCache();
    }

    public function getAddressable(string $key): array
    {
        return app(AddressParser::class)->parse($this->headers[$key] ?? '');
    }
}

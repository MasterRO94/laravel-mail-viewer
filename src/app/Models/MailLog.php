<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MailLog
 *
 * @package MasterRO\MailViewer\Models
 */
class MailLog extends Model
{
    protected static $unguarded = true;

    public $timestamps = false;

    protected $casts = [
        'from'        => 'object',
        'to'          => 'object',
        'cc'          => 'object',
        'bcc'         => 'object',
        'date'        => 'datetime',
        'headers'     => 'array',
        'attachments' => 'array',
    ];

    /**
     * Appends
     *
     * @var array
     */
    protected $appends = [
        'formattedTo', 'formattedFrom', 'formattedCc', 'formattedBcc', 'formattedDate', 'formattedTime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('mail-viewer.table', 'mail_logs'));
        $this->setConnection(config('mail-viewer.connection', config('database.default')));
    }

    public function getFormattedFromAttribute(): string
    {
        return $this->formattedAddress('from');
    }

    public function getFormattedToAttribute(): string
    {
        return $this->formattedAddress('to');
    }

    public function getFormattedCcAttribute(): string
    {
        return $this->formattedAddress('cc');
    }

    public function getFormattedBccAttribute(): string
    {
        return $this->formattedAddress('bcc');
    }

    public function formattedAddress(string $field): string
    {
        return collect($this->{$field})->map(function ($mailbox) {
            return ($mailbox->name ? "<span class=\"mail-item-name\">{$mailbox->name}</span>" : '')
                . " &lt;<span class=\"mail-item-email\">{$mailbox->email}</span>&gt;";
        })->implode(', ');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->date->format(config('mail-viewer.date_format'));
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->date->format(config('mail-viewer.time_format'));
    }
}

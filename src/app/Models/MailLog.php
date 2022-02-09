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

    /**
     * Timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Dates
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'from'        => 'object',
        'to'          => 'object',
        'cc'          => 'object',
        'bcc'         => 'object',
        'attachments' => 'array',
    ];

    /**
     * Appends
     *
     * @var array
     */
    protected $appends = ['formattedTo', 'formattedFrom', 'formattedCc', 'formattedBcc', 'formattedDate'];

    /**
     * MailLog constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('mail-viewer.table', 'mail_logs'));
        $this->setConnection(config('mail-viewer.connection', config('database.default')));
    }

    /**
     * @return string
     */
    public function getFormattedFromAttribute()
    {
        return $this->formattedAddress('from');
    }

    /**
     * @return string
     */
    public function getFormattedToAttribute()
    {
        return $this->formattedAddress('to');
    }

    /**
     * @return string
     */
    public function getFormattedCcAttribute()
    {
        return $this->formattedAddress('cc');
    }

    /**
     * @return string
     */
    public function getFormattedBccAttribute()
    {
        return $this->formattedAddress('bcc');
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function formattedAddress(string $field)
    {
        return collect($this->{$field})->map(function ($mailbox) {
            return ($mailbox->name ? "<span class=\"mail-item-name\">{$mailbox->name}</span>" : '')
                . " &lt;<span class=\"mail-item-email\">{$mailbox->email}</span>&gt;";
        })->implode(', ');
    }

    /**
     * @return mixed
     */
    public function getFormattedDateAttribute()
    {
        return $this->date->format(config('mail-viewer.date_format'));
    }
}

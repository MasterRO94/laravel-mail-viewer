<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MasterRO\MailViewer\Models\MailLog;

class Resource
{
    protected array $fields = [
        'id',
        'subject',
        'body',
        'from',
        'to',
        'cc',
        'bcc',
        'date',
        'headers',
        'attachments',
    ];

    public function fetch(Request $request): LengthAwarePaginator
    {
        return MailLog::latest('date')
            ->when($request->input('search'), fn(Builder $query) => $query->search($request->input('search')))
            ->paginate($request->input('per_page', config('mail-viewer.emails_per_page', 20)), $this->fields);
    }
}

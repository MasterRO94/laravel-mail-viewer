<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            ->when(
                $request->input('search'),
                fn(Builder $query) => $query->search($request->input('search'))
            )
            ->when(
                $request->input('dateFrom'),
                fn(Builder $query) => $query->where('date', '>=', $request->date('dateFrom')),
            )
            ->when(
                $request->input('dateTo'),
                fn(Builder $query) => $query->where('date', '<=', $request->date('dateTo')),
            )
            ->paginate($request->input('per_page', config('mail-viewer.emails_per_page', 20)), $this->fields);
    }

    public function stats(): array
    {
        return collect([
            'today'      => [now()->startOfDay(), now()->endOfDay()],
            'this_week'  => [now()->startOfWeek(), now()->endOfDay()],
            'this_month' => [now()->startOfMonth(), now()->endOfDay()],
        ])
            ->mapWithKeys(fn(array $range, string $key) => [
                Str::headline($key) => MailLog::whereBetween('date', $range)->count(),
            ])
            ->toArray();
    }
}

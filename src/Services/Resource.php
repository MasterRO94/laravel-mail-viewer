<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use MasterRO\MailViewer\Models\MailLog;

class Resource
{
    protected array $fields = [
        'id',
        'subject',
        'body',
        'text',
        'date',
        'headers',
        'attachments',
    ];

    public function fetch(Request $request): LengthAwarePaginator
    {
        return MailLog::latest('date')
            ->when(
                $request->input('search'),
                fn(Builder $query) => $query->search($request->input('search')),
            )
            ->when(
                $request->input('dateFrom'),
                fn(Builder $query) => $query->where('date', '>=', $request->date('dateFrom')),
            )
            ->when(
                $request->input('dateTo'),
                fn(Builder $query) => $query->where('date', '<=', $request->date('dateTo')),
            )
            ->paginate(
                $request->input('per_page', config('mail-viewer.emails_per_page', 20)),
                $request->has('slim')
                    ? array_filter($this->fields, static fn(string $field) => !in_array($field, ['body']))
                    : $this->fields,
            );
    }

    public function stats(): array
    {
        return $this->statRanges()
            ->map(static fn(array $range, string $key) => [
                'key' => Str::snake($key),
                'value' => MailLog::whereBetween('date', $range)->count(),
                'title' => "Sent {$key}",
            ])
            ->pipe(static fn(Collection $data) => ['data' => $data->values()->toArray()]);
    }

    protected function statRanges(): Collection
    {
        $pruneOlderThanDays = config('mail-viewer.prune_older_than_days', 365);

        return collect([
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
            'this week' => [now()->startOfWeek(), now()->endOfDay()],
            'this month' => [now()->startOfMonth(), now()->endOfDay()],
            'this year' => [now()->startOfYear(), now()->endOfYear()],
            'total' => [Date::create(2018, 12, 11), now()->endOfDay()],
        ])->reject(
            static fn(array $range, string $key) => $key !== 'total'
                && $pruneOlderThanDays > 0
                && $range[0]->diffInDays() > $pruneOlderThanDays,
        );
    }
}

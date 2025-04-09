<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

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

    public function fetch(Request $request): array
    {
        $perPage = $request->input(
            'per_page',
            config('mail-viewer.emails_per_page', 20),
        );

        $baseQuery = MailLog::latest('id')
            ->when(
                $request->input('search'),
                fn(Builder $query) => $query->search($request->input('search')),
            )
            ->when(
                $request->input('startDate'),
                fn(Builder $query) => $query->where('date', '>=', $request->date('startDate')->startOfDay()),
            )
            ->when(
                $request->input('endDate'),
                fn(Builder $query) => $query->where('date', '<=', $request->date('endDate')->endOfDay()),
            )
            ->when(
                $request->input('oldestId'),
                fn(Builder $query) => $query->where('id', '<', $request->integer('oldestId')),
            )
            ->when(
                $request->input('latestId'),
                fn(Builder $query) => $query->where('id', '>', $request->integer('latestId')),
            );

        $items = $baseQuery->clone()
            ->take($perPage)
            ->get($this->fields);

        $hasMoreItems = $baseQuery->clone()->take($perPage + 1)->count() > $perPage;

        return [
            'data' => $items,
            'perPage' => $perPage,
            'hasMoreItems' => $hasMoreItems,
        ];
    }

    public function stats(): array
    {
        return $this->statRanges()
            ->map(static fn(array $range, string $key) => [
                'key' => Str::snake($key),
                'value' => MailLog::whereBetween('date', $range)->count(),
                'title' => "Sent {$key}",
            ])
            ->values()
            ->toArray();
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

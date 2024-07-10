<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use App\Models\User;
use Flowframe\Trend\TrendValue;
use Flowframe\Trend\Trend;

class PostWidget extends ChartWidget
{
    protected static ?string $heading = 'Post Chart';

    protected function getData(): array
    {
        $data = Trend::model(Post::class)
        ->between(
            start: now()->subDays(4),
            end: now(),
        )
        ->perDay()
        ->count();
        // dd($data);
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

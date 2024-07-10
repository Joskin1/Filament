<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
            ->description('Total Users in the group')
            ->descriptionIcon('heroicon-s-users', IconPosition::Before)
            ->chart([1,4,3,7,2,9,5,0,6])
            ->color('success')
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UserStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Registered Users', User::count())
                ->description('All registered users')
                ->icon('heroicon-o-users'),
        ];
    }
}

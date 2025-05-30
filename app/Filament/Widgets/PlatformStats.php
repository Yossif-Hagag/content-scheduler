<?php
namespace App\Filament\Widgets;

use App\Models\Platform;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PlatformStats extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();

        return [
            Card::make('Total Platforms', Platform::count()),
        ];
    }
}

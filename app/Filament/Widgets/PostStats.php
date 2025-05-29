<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostStats extends BaseWidget
{
    protected function getCards(): array
    {
        $user = Auth::user();

        return [
            Card::make('Total Posts', Post::count()),
            Card::make('Draft Posts', Post::where('status', 'draft')->count()),
            Card::make('Scheduled Posts', Post::where('status', 'scheduled')->count()),
            Card::make('Published Posts', Post::where('status', 'published')->count()),
        ];
    }
}

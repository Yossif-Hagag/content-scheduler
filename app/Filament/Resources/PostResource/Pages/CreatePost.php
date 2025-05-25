<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Notification;
use Carbon\Carbon;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();
        if (
            Post::where('user_id', auth()->id())
                ->where('status', 'scheduled')
                ->whereBetween('scheduled_time', [$todayStart, $todayEnd])
                ->count() >= 10
        ) {

            Notification::make()
                ->title('You have reached the daily limit of 10 scheduled posts.')
                ->danger()
                ->send();

            redirect()->back()->send();
        }

        $data['user_id'] = auth()->id();
        return $data;
    }


    protected function afterCreate(): void
    {
        if (isset($this->form->getState()['platforms'])) {
            $this->record->platforms()->sync($this->form->getState()['platforms']);
        }
    }
}

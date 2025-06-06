<?php

namespace Database\Seeders;

use App\Enums\UserType;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Platform;

class UserPlatformSeeder extends Seeder
{
    public function run()
    {
        $platformIds = Platform::pluck('id')->toArray();

        User::all()->each(function ($user) use ($platformIds) {
            // Skip admin users, they don't need active platforms
            if ($user->type === UserType::Admin) {
                return;
            }
            // activate 1-4 random platforms for every user
            $activePlatforms = collect($platformIds)->random(rand(1, 4))->toArray();
            $user->activePlatforms()->sync($activePlatforms);
        });
    }
}

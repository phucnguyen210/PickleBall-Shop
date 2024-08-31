<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
// use Laravolt\Avatar\Avatar;
use Laravolt\Avatar\Facade as Avatar;



class GenerateUserAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:avatars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate avatars for all existing users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Kiểm tra nếu người dùng đã có avatar, bỏ qua
            // if ($user->img != null) {
            //     $this->info('Avatar already exists for user: ' . $user->name);
            //     continue;
            // }

            $avatarPath = 'avatar-' . $user->id . '.png';
            Avatar::create($user->name)->save(public_path('img-avatar/' . $avatarPath));
            $user->avatar = $avatarPath;
            $user->save();
            $this->info('Avatar generated for user: ' . $user->name);
        }

        $this->info('Avatars have been generated for all users.');
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Channel;
use App\Models\User;
use App\Models\Message;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        // Create public and private channels
        $channels = (object) [
            'public' => factory(Channel::class, 10)->state('public')
                ->create(),
            'private' => factory(Channel::class, 10)->state('private')
                ->create(),
        ];

        $users->each(function($user) use ($channels) {
            factory(Message::class, 100)->make()->each(function($message) use ($user, $channels) {
                $type = (rand(0, 1) === 1) ? 'private' : 'public';

                $message->conversation_id = $channels->{$type}->random()->conversation->id;
                $user->messages()->save($message);
            });
        });
    }
}

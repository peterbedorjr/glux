<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function(Faker $faker) {
    return [
        'conversation_id' => function() {
            return factory(\App\Models\Conversation::class)->create()->id;
        },
        'name' => ucfirst($faker->word),
    ];
});

$factory->state(Channel::class, 'public', function() {
    return [
        'private' => false,
    ];
});

$factory->state(Channel::class, 'private', function() {
    return [
        'private' => true,
    ];
});

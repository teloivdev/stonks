<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PriceHistory;
use App\Team;
use App\Player;
use Faker\Generator as Faker;

$factory->define(PriceHistory::class, function (Faker $faker) {
    $player = Player::where('role', '!=', '')->get();
    $player = $player->random();
    return [
        'player_id' => $player->id,
        'price' => rand(5, 10),
        'created_at' => $faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now', $timezone = null) 
    ];
});

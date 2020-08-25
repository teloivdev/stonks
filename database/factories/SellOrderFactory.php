<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SellOrder;
use Faker\Generator as Faker;

$factory->define(SellOrder::class, function (Faker $faker) {
    $p = App\Player::whereNotIn('role', [''])->get()->random();
    $u = App\User::all()->random();
    return [
        'player_id' => $p->id,
        'user_id' => $u->id,
        'price' => 10,
        'amount' => 100,
        'available_amount' => 100,
        'filled' => 0
    ];
});

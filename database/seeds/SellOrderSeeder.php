<?php

use Illuminate\Database\Seeder;
use App\Player;
use App\PriceHistory;
class SellOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SellOrder::class, 1000)->create()->each(function ($so) {
            $so->save();
            $ph = PriceHistory::create(['player_id' => $so->player_id, 'price' => $so->price]);
            $ph->save();
        });
    }
}

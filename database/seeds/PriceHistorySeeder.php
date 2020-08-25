<?php

use Illuminate\Database\Seeder;

class PriceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PriceHistory::class, 1000)->create()->each(function ($p) {
            $p->save();
        });
    }
}

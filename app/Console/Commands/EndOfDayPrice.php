<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Player;
use App\PriceHistory;
class EndOfDayPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull last price history and insert';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $players = Player::all();
        foreach ($players as $p)
        {
            $ph = PriceHistory::where('player_id', $p->id)->latest()->get();
            if ($ph == null)
                $createPh = PriceHistory::create(['player_id' => $p->id, 'price' => 5]);
            else
                $logPh = PriceHistory::create(['player_id' => $p->id, 'price' => $ph->price]);
        }
    }
}

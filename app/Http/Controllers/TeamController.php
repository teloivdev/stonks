<?php

namespace App\Http\Controllers;

use App\Team;
use App\Player;
use App\PriceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchAutocomplete(Request $req, $game)
    {
        $teams = Team::where('name', 'like', '%'. $req->search .'%')->skip(0)->take(5)->get();
        return response()->json($teams);

    }

    public function index(Request $req)
    {
        $team = Team::find($req->id);
        $players = Player::where('team', $team->name)->where('role', '!=', '')->get();
        foreach ($players as $player)
        {
            $ph24Hour = PriceHistory::where('player_id', $player->id)->first();
            $ph = PriceHistory::where('player_id', $player->id)->latest()->first();
            $player->last_price = $ph != null ? $ph->price : 1;
            $player->last_24_price = $ph24Hour != null ? $ph24Hour->price : 1;
            $arrow = $player->last_price - $player->last_24_price > 0 ? 'up' : 'down';
            $priceDiff = $player->last_price - $player->last_24_price;
            $player->arrow = $arrow;
            $player->priceDiff = $priceDiff;


        }
        return view('team.team')->with(['team' => $team, 'players' => $players]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $currentAveragePrice = 0;
        $oldAveragePrice = 0;

        $teams = Team::all();
        foreach ($teams as $t)
        {
            $players = Player::where('team', $t->name)->where('role', '!=', '')->get();
            foreach ($players as $p)
            {   
                $oldPriceHistory = PriceHistory::where('player_id', $p->id)->where('created_at', '<', Carbon::parse('-1 hours'))->first();
                $currentPriceHistory = PriceHistory::where('player_id', $p->id)->latest()->first();
                
                $oldAveragePrice += $oldPriceHistory != null ? $oldPriceHistory->price : 0;
                $currentAveragePrice += $currentPriceHistory != null ? $currentPriceHistory->price : 0;
            }
            $currentAveragePrice = $currentAveragePrice / sizeOf($players);
            $oldAveragePrice = $oldAveragePrice / sizeOf($players);
            $priceDiff = $currentAveragePrice - $oldAveragePrice;
            $arrow = $currentAveragePrice - $oldAveragePrice > 0 ? 'up' : 'down';
    
            $t->priceDiff = number_format($priceDiff, 2);
            $t->arrow = $arrow;
            $t->oldAveragePrice = number_format($oldAveragePrice, 2);
            $t->currentAveragePrice = number_format($currentAveragePrice, 2);
        }
        return view('team.owlTeams')->with('teams', $teams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}

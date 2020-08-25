<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team;
use App\PriceHistory;
use App\SellOrder;
use App\BuyOrder;
use App\Events\PriceHistoryCreated;
use App\Position;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchAutocomplete(Request $req, $game)
    {
        $players = Player::where('game', $game)->where('handle', 'like', '%'. $req->search .'%')->skip(0)->take(5)->get();
        return response()->json($players);

    }

    public function fetchCurrentPrice(Request $req, $game)
    {

    }

    public function fetchLast7Graph(Request $req)
    {
        $ph = PriceHistory::where('player_id', $req->id)->whereDay('created_at', '>=', Carbon::today('America/Chicago')->subDays(7))->
            whereDay('created_at', '<=', Carbon::today())->orderBy('created_at', 'asc')->get();
        return response()->json($ph);
    }
    public function fetchLastTrades(Request $req)
    {
        $ph = PriceHistory::where('player_id', $req->id)->orderBy('id', 'asc')->get();
        return response()->json($ph);
    }

    public function index(Request $req)
    {
        $userPosition = null;
        $userUnfilledBuyOrders = [];
        $userFilledBuyOrders = []; 
        $userUnfilledSellOrders = [];
        $userFilledSellOrders = [];

        $player = Player::find($req->id);
        $ph = PriceHistory::where('player_id', $player->id)->latest()->first();
        //$sellOrders = SellOrder::where('player_id', $player->id)->where('filled', '0')->orderBy('price', 'desc')->skip(0)->take(10)->get();
        $sellOrders = SellOrder::where('player_id', $player->id)->where('filled', '0')->orderBy('price', 'desc')->paginate(25);

        $buyOrders = BuyOrder::where('player_id', $player->id)->where('filled', '0')->orderBy('price', 'desc')->skip(0)->take(10)->get();
        $player->last_price = $ph != null ? $ph->price : 1;

        if (Auth::check())
        {
            $userPosition = Position::where(['user_id' => auth()->user()->id, 'player_id' => $player->id])->first() == null ?
                0 : Position::where(['user_id' => auth()->user()->id, 'player_id' => $player->id])->first()->amount;

            $userUnfilledBuyOrders = BuyOrder::where('user_id', auth()->user()->id)->where('filled', 0)->
                where('player_id', $player->id)->orderBy('created_at', 'asc')->paginate(5);
            $userFilledBuyOrders = BuyOrder::where('user_id', auth()->user()->id)->where('filled', 1)->
                where('player_id', $player->id)->orderBy('created_at', 'asc')->paginate(5);

            $userUnfilledSellOrders = SellOrder::where('user_id', auth()->user()->id)->where('filled', 0)->
                where('player_id', $player->id)->orderBy('created_at', 'asc')->paginate(5);
            $userFilledSellOrders = SellOrder::where('user_id', auth()->user()->id)->where('filled', 1)->
                where('player_id', $player->id)->orderBy('created_at', 'asc')->paginate(5);
        }
        return view('player.player')->with([
            'player' => $player,
            'sellOrders' => $sellOrders,
            'buyOrders' => $buyOrders,
            'priceHistory' => $ph,
            'userPosition' => $userPosition,
            'userUnfilledBuyOrders' => $userUnfilledBuyOrders,
            'userFilledBuyOrders' => $userFilledBuyOrders,
            'userUnfilledSellOrders' => $userUnfilledSellOrders,
            'userFilledSellOrders' => $userFilledSellOrders
        ]);
    }

    public function refresh(Request $req)
    {
        $player = Player::find($req->id);
        $ph = PriceHistory::where('player_id', $player->id)->latest()->first();
        $sellOrders = SellOrder::where('player_id', $player->id)->where('filled', '0')->orderBy('price', 'asc')->skip(0)->take(10)->get();
        $buyOrders = BuyOrder::where('player_id', $player->id)->where('filled', '0')->orderBy('price', 'asc')->skip(0)->take(10)->get();

        $player->last_price = $ph != null ? $ph->price : 1;
        $v = view('player.playerInfo')->with([
            'player' => $player,
            'sellOrders' => $sellOrders,
            'buyOrders' => $buyOrders,
            'priceHistory' => $ph
        ]);
        return $v->render();

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
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //
    }
}

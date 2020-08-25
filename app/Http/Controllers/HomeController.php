<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SellOrder;
use App\BuyOrder;
use Auth;
use Illuminate\Support\Collection;
use App\PriceHistory;
use Carbon\Carbon;
use App\Player;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $unfilledBuyOrders = $this->getUnfilledBuyOrder();
        $unfilledSellOrders = $this->getUnfilledSellOrder();

        $filledBuyOrders = $this->getFilledBuyOrder();
        $filledSellOrders = $this->getFilledSellOrder();

        return view('home.home')->with([
            'unfilledBuyOrders' => $unfilledBuyOrders,
            'unfilledSellOrders' => $unfilledSellOrders,
            'filledBuyOrders' => $filledBuyOrders,
            'filledSellOrders' => $filledSellOrders
            ]);
    }

    public function getUnfilledBuyOrder() 
    {
        $buyOrders = BuyOrder::where('user_id', auth()->user()->id)->where('filled', 0)->
            orderBy('created_at', 'asc')->paginate(25, ['*'], 'unFilledBuyOrders');
        foreach($buyOrders as $bo)
        {
            $date = Carbon::parse($bo->created_at);
            $now = Carbon::now();
            
            $timeElapsed = $date->diffInDays($now);

            $ph = PriceHistory::where('player_id', $bo->player_id)->latest()->first();
            $player = Player::where('id', $bo->player_id)->first();

            $bo->created_at_formatted = Carbon::parse($bo->created_at)->format('m/d/Y');

            $bo->timeElapsed = $timeElapsed;
            $bo->playerHandle = $player->handle;
            $bo->playerId = $player->id;
            $bo->latestPrice = $ph->price;
        }
        return $buyOrders;
    }

    public function getFilledBuyOrder() 
    {
        $buyOrders = BuyOrder::where('user_id', auth()->user()->id)->where('filled', 1)->
            orderBy('created_at', 'asc')->paginate(25, ['*'], 'filledBuyOrders');
        foreach($buyOrders as $bo)
        {
            $date = Carbon::parse($bo->created_at);
            $now = Carbon::now();
            
            $timeElapsed = $date->diffInDays($now);

            $ph = PriceHistory::where('player_id', $bo->player_id)->latest()->first();
            $player = Player::where('id', $bo->player_id)->first();

            $bo->created_at_formatted = Carbon::parse($bo->created_at)->format('m/d/Y');

            $bo->timeElapsed = $timeElapsed;
            $bo->playerHandle = $player->handle;
            $bo->playerId = $player->id;
            $bo->latestPrice = $ph->price;
        }
        return $buyOrders;
    }

    public function getUnfilledSellOrder() 
    {
        $sellOrders = SellOrder::where('user_id', auth()->user()->id)->where('filled', 0)->
            orderBy('created_at', 'asc')->paginate(25, ['*'], 'unFilledSellOrders');
        foreach($sellOrders as $so)
        {
            $ph = PriceHistory::where('player_id', $so->player_id)->latest()->first();
            $priceDiff = $ph->price - $so->price;
            $ph->priceDiff = $priceDiff;
            $player = Player::where('id', $so->player_id)->first();

            $so->created_at_formatted = Carbon::parse($so->created_at)->format('m/d/Y');
            $so->latestPrice = $ph->price;
            $so->playerHandle = $player->handle;
            $so->playerId = $player->id;
            $so->priceDiff = $priceDiff;
        } 
        return $sellOrders;
    }

    public function getFilledSellOrder() 
    {
        $sellOrders = SellOrder::where('user_id', auth()->user()->id)->where('filled', 1)->
            orderBy('created_at', 'asc')->paginate(25, ['*'], 'filledSellOrders');
        foreach($sellOrders as $so)
        {
            $ph = PriceHistory::where('player_id', $so->player_id)->latest()->first();
            $priceDiff = $ph->price - $so->price;
            $ph->priceDiff = $priceDiff;
            $player = Player::where('id', $so->player_id)->first();

            $so->created_at_formatted = Carbon::parse($so->created_at)->format('m/d/Y');
            $so->latestPrice = $ph->price;
            $so->playerHandle = $player->handle;
            $so->playerId = $player->id;
            $so->priceDiff = $priceDiff;
        } 
        return $sellOrders;
    }
}

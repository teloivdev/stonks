<?php

namespace App\Http\Controllers;

use App\BuyOrder;
use App\User;
use App\SellOrder;
use App\PriceHistory;
use App\Events\PriceHistoryCreated;
use App\Events\SellOrderCreated;
use App\Events\SellOrderFilled;
use Illuminate\Http\Request;
use App\Position;

class SellOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $user = User::find($req->user_id);
        $total = 0;
        $amount = $req->amount;
        $price = $req->price;
        $initialTotalAmount = $req->amount;

        while($amount > 0)
        {
            $buyOrder = BuyOrder::where('player_id', $req->player_id)->where('price', '>=', $price)->
            where('filled', '0')->orderBy('price', 'desc')->first();
            if ($buyOrder == null)
            {
                $unfilled = SellOrder::create([
                    'user_id' => $req->user_id,
                    'player_id' => $req->player_id,
                    'price' => $price,
                    'amount' => $initialTotalAmount,
                    'available_amount' => $amount,
                    'filled' => 0
                ]);
                event(new SellOrderCreated($req->player_id));
                break;
            }
            else 
            {
                $filledAmount = $buyOrder->available_amount >= $amount ? $amount : $buyOrder->available_amount;
                $buyOrderRemainingAmount = $buyOrder->available_amount >= $amount ? $buyOrder->amount - $amount : 0;

                $filled = SellOrder::create([
                    'user_id' => $req->user_id,
                    'player_id' => $req->player_id,
                    'price' => $price,
                    'amount' => $filledAmount,
                    'available_amount' => null,
                    'filled' => 1
                ]);
                event(new SellOrderFilled($filled->id));

                $position = Position::where([
                    'player_id' => $filled->player_id,
                    'user_id' => $filled->user_id
                ])->first();
                $position->amount -= $filled->amount;
                $position->save();

                $total = $filled->amount * $filled->price;
                $amount = $amount - $filledAmount;

                $ph = PriceHistory::create([
                    'player_id' => $filled->player_id,
                    'price' => $filled->price
                ]);
                event(new PriceHistoryCreated($ph));

                $user->balance = $user->balance + $total;

                $buyOrder->available_amount = $buyOrderRemainingAmount;                
                $buyOrder->filled = $buyOrder->available_amount == 0 ? 1 : 0;

                $user->update();
                $buyOrder->update();

            }
        }
        return redirect()->route('playerHome', ['id' => $req->player_id]);
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
     * @param  \App\SellOrder  $sellOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SellOrder $sellOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SellOrder  $sellOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(SellOrder $sellOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SellOrder  $sellOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellOrder $sellOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SellOrder  $sellOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        $delete = SellOrder::destroy($req->id);
        return back();
    }
}

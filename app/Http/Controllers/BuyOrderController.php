<?php

namespace App\Http\Controllers;

use App\BuyOrder;
use App\User;
use App\SellOrder;
use App\PriceHistory;
use App\Events\PriceHistoryCreated;
use App\Events\BuyOrderCreated;
use App\Events\BuyOrderFilled;
use App\Position;

use Illuminate\Http\Request;

class BuyOrderController extends Controller
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
        $initialTotalAmount = $req->amount;
        $price = $req->price;
        while($amount > 0)
        {
            $sellOrder = SellOrder::where('player_id', $req->player_id)->where('price', '<=', $price)->where('filled', '0')->orderBy('price', 'asc')->first();
            if ($sellOrder == null)
            {
                $unfilled = BuyOrder::create([
                    'user_id' => $req->user_id,
                    'player_id' => $req->player_id,
                    'price' => $req->price,
                    'amount' => $initialTotalAmount,
                    'available_amount' => $amount,
                    'filled' => 0
                ]);
                event(new BuyOrderCreated($req->player_id));
                break;
            }
            else 
            {   
                //actual fill amount, can be 0
                $filledAmount = $sellOrder->available_amount >= $amount ? $amount : $amount - $sellOrder->available_amount;
                $sellOrderRemainingAmount = $sellOrder->available_amount >= $amount ? $sellOrder->available_amount - $amount : 0;

                $filled = BuyOrder::create([
                    'user_id' => $req->user_id,
                    'player_id' => $req->player_id,
                    'price' => $sellOrder->price,
                    'amount' => $filledAmount,
                    'available_amount' => 0,
                    'filled' => 1
                ]);
                event(new BuyOrderFilled($filled->id));

                $position = Position::firstOrCreate([
                    'player_id' => $filled->player_id,
                    'user_id' => $filled->user_id
                ]);
                $position->amount += $filled->amount;
                $position->save();

                $total = $filled->amount * $filled->price;
                $amount = $amount - $filledAmount;

                $ph = PriceHistory::create([
                    'player_id' => $filled->player_id,
                    'price' => $filled->price
                ]);
                event(new PriceHistoryCreated($ph));

                $user->balance = $user->balance - $total;

                $sellOrder->available_amount = $sellOrderRemainingAmount;
                $sellOrder->filled = $sellOrder->available_amount == 0 ? 1 : 0;

                $user->update();
                $sellOrder->update();

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
     * @param  \App\BuyOrder  $buyOrder
     * @return \Illuminate\Http\Response
     */
    public function show(BuyOrder $buyOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BuyOrder  $buyOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(BuyOrder $buyOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BuyOrder  $buyOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuyOrder $buyOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BuyOrder  $buyOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        $delete = BuyOrder::destroy($req->id);
        return back();
    }
}

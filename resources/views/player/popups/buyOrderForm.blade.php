<div class="modal fade" id="buyOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background: #e43f5a">
            <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Create A Buy Order</h4>
        </div>            <!-- Modal Body -->
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h3>Owned Stock: {{$userPosition}}</h3>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                        <form action="/overwatch/player/create/buy" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="player_id" value="{{$player->id}}"/>
                            <input type="hidden" class="form-control" name="user_id" value="{{Auth::id()}}"/>
                            <label for="price" class="form-check-label">Current Price</label>
                            <input type="number" class="form-control" id="buyPrice" name="price" step=".50" value="{{$player->last_price}}" required/>

                            <label for="amount" class="form-check-label">Amount</label>
                            <input type="number" class="form-control" name="amount" value="1" min="1" required/>
                            <br/>
                            <input type="submit" class="form-control btn btn-primary" name="submit"/>
                        </form>
                    </div>
                    <div class="col"></div>
                </div>
            <div class="modal-body">
                <div class="modal-footer" id="modal_footer">
                    <!--<input id="btnSubmit" name="btnSubmit" value="Donate" class="btn btn-default-border-blk" type="submit">-->
                    <input type="submit" name="submit" class="btn btn-default-border-blk" value="Create Order"/>
                </div>
                <button type="submit"  class="btn btn btn-primary" data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#buyOrderModal">Close</button>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col centerTop">
                        <h3>Your Orders</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col centerTop">
                    <div class="table-responsive">
                        <h4>Open Buy Orders</h4>
                        <table class="table table-bordered">
                        <tr style="color: white; font-size: .9em;">
                                <th>Price</th>
                                <th>Created At</th>
                                <th>Amount</th>
                                <th>Cancel</th>
                        </tr>
                        @foreach ($userUnfilledBuyOrders as $userUnfilledBO)
                            <tr style="color: white;">
                                <td>{{$userUnfilledBO->price}}</td>
                                <td>{{ \Carbon\Carbon::parse($userUnfilledBO->created_at)->format('j, F, Y')}}</td>
                                <td>{{$userUnfilledBO->amount}}</td>
                                <td style="text-align: center; font-size: 1.1em;">
                                    <form action="{{ url('/overwatch/player/destroy/buy', ['id' => $userUnfilledBO->id]) }}" method="post">
                                        <input class="btn btn-danger" type="submit" value="&#10008;" />
                                        <input type="hidden" name="_method" value="delete" />
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                    </div>
                    <div class="col centerTop">
                    <div class="table-responsive">
                        <h4>Filled Sell Orders</h4>
                        <table class="table table-bordered">
                        <tr style="color: white; font-size: .9em;">
                                <th>Price</th>
                                <th>Filled At</th>
                                <th>Amount</th>
                        </tr>
                        @foreach ($userFilledSellOrders as $userFilledSO)
                            <tr style="color: white;">
                                <td>{{$userFilledSO->price}}</td>
                                <td>{{$userFilledSO->created_at}}</td>
                                <td>{{$userFilledSO->amount}}</td>
                            </tr>           
                        @endforeach
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
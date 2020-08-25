<div class="tab-content" id="pills-subTabFilledOrders">
            <div class="tab-pane fade show active" id="pills-filledBuyOrders" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="container">
                    <div class="table-responsive">
                        <h1>Filled Buy Orders</h1>
                        {{$filledBuyOrders->links()}}
                        <table class="table table-striped table-dark">
                        <thead class="thead-dark">
                            <tr>
                                <th>Player</th>
                                <th>Price Per</th>
                                <th>Created Date</th>
                                <th>Amount</th>
                                <th>Current Trading Price</th>
                            </tr>
                        </thead>
                        @foreach ($filledBuyOrders as $bo)
                            <tr>
                                <td><a href="overwatch/player/{{$bo->playerId}}">{{$bo->playerHandle}}</a></td>
                                <td>{{$bo->price}}</td>
                                <td>{{$bo->created_at_formatted}}</td>
                                <td>{{$bo->amount}}</td>
                                <td>{{$bo->price}}</td>
                            </tr>
                        @endforeach
                        </table>
                        {{$filledBuyOrders->links()}}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-filledSellOrders" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="container">
                    <div class="table-responsive">
                        <h1>Filled Sell Orders</h1>
                        <table class="table table-striped table-dark">
                            <thead class="thead-dark">
                            <tr>
                                <th>Player</th>
                                <th>Price Per</th>
                                <th>Created Date</th>
                                <th>Amount</th>
                                <th>Current Trading Price</th>
                            </tr>
                            </thead>
                        @foreach ($filledSellOrders as $so)
                            <tr>
                                <td><a href="overwatch/player/{{$so->playerId}}">{{$so->playerHandle}}</a></td>
                                <td>{{$so->price}}</td>
                                <td>{{$so->created_at_formatted}}</td>
                                <td>{{$so->amount}}</td>
                                <td>{{$so->price}}</td>
                            </tr>
                        @endforeach
                        </table>
                        {{$filledSellOrders->links()}}
                    </div>
                </div>          
            </div>
        </div>

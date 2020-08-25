<div class="tab-content" id="pills-subTabUnfilledOrders">
            <div class="tab-pane fade show active" id="pills-unfilledBuyOrders" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="container">
                    <div class="table-responsive">
                        <h1>Open Buy Orders</h1>
                        {{$unfilledBuyOrders->links()}}
                        <table class="table table-striped table-dark">
                        <thead class="thead-dark">
                            <tr>
                                <th>Player</th>
                                <th>Price Per</th>
                                <th>Created Date</th>
                                <th>Amount</th>
                                <th>Current Trading Price</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        @foreach ($unfilledBuyOrders as $bo)
                            <tr>
                                <td><a href="overwatch/player/{{$bo->playerId}}">{{$bo->playerHandle}}</a></td>
                                <td>{{$bo->price}}</td>
                                <td>{{$bo->created_at_formatted}}</td>
                                <td>{{$bo->amount}}</td>
                                <td>{{$bo->price}}</td>
                                <td style="text-align: center; font-size: 1.1em;">
                                <form action="{{ url('/overwatch/player/destroy/buy', ['id' => $bo->id]) }}" method="post">
                                    <input class="btn btn-danger" type="submit" value="&#10008;" />
                                    <input type="hidden" name="_method" value="delete" />
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                                    </td>
                            </tr>
                        @endforeach
                        </table>
                        {{$unfilledBuyOrders->links()}}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-unfilledSellOrders" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="container">
                    <div class="table-responsive">
                        <h1>Open Sell Orders</h1>
                        <table class="table table-striped table-dark">
                        <thead class="thead-dark">
                            <tr>
                                <th>Player</th>
                                <th>Price Per</th>
                                <th>Created Date</th>
                                <th>Amount</th>
                                <th>Current Trading Price</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        @foreach ($unfilledSellOrders as $so)
                            <tr>
                                <td><a href="overwatch/player/{{$so->playerId}}">{{$so->playerHandle}}</a></td>
                                <td>{{$so->price}}</td>
                                <td>{{$so->created_at_formatted}}</td>
                                <td>{{$so->amount}}</td>
                                <td>{{$so->price}}</td>
                                <td style="text-align: center; font-size: 1.1em;">
                                <form action="{{ url('/overwatch/player/destroy/buy', ['id' => $so->id]) }}" method="post">
                                    <input class="btn btn-danger" type="submit" value="&#10008;" />
                                    <input type="hidden" name="_method" value="delete" />
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                                    </td>
                            </tr>
                        @endforeach
                        </table>
                        {{$unfilledSellOrders->links()}}
                    </div>
                </div>          
            </div>
        </div>
        <script>
            function setPageOne() {

            var queryParams = new URLSearchParams(window.location.search);
            
            // Set new or modify existing parameter value. 
            queryParams.set("page", "1");
            
            // Replace current querystring with the new one.
            history.replaceState(null, null, "?"+queryParams.toString());
            }
        </script>
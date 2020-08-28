<div class="container">
    <div class="row">
    <div class="col">
    </div>
        <div class="col" style="text-align: center;">
            <h1>{{$player->handle}}</h1>
        </div>
    <div class="col"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col centerCenter">
            <h1 id="currentPrice">{{$player->last_price}}</h1>
            @include('player.playerPriceGraph')
        </div>
        <div class="col-3"></div>
    </div>
    <br/>
    <div class="row">
        <div class="col col-sm-6 centerCenter">
            <button type="submit"  class="btn btn btn-primary" data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#buyOrderModal">Manage Buy Orders</button>
        </div>  
        <div class="col col-sm-6 centerCenter">
            <button type="submit"  class="btn btn btn-primary" data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#sellOrderModal">Manage Sell Orders</button>
        </div>  
    </div>
    <br/>
    <div class="row">
        <div class="col-md col-sm-12 centerTop">
            <div id="buyOrderList">
                <div class="table-responsive">
                    <h4>Open Buy Orders</h4>
                    <table class="table table-striped table-dark" id="buyOrderTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Created Date</th>
                            </tr>
                        </thead>
                        <tbody id="buyOrderRows">
                        @foreach ($buyOrders as $bo)
                        <tr style="color: white;">
                            <td>{{$bo->price}}</td>
                            <td>{{$bo->amount}}</td>
                            <td>{{ \Carbon\Carbon::parse($bo->created_at)->subDays(1)->format('j, F, Y')}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>       
                </div> 
            </div>
        </div>
        <div class="col-md col-sm-12 centerTop">
            <div id="sellOrderList">
                <div class="table-responsive">
                    <h4>Open Sell Orders</h4>
                    <table class="table table-striped table-dark" id="sellOrderTable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Created Date</th>
                            </tr>
                        </thead>
                        <tbody id="sellOrderRows">
                        @foreach ($sellOrders as $so)
                        <tr style="color: white;">
                            <td>{{$so->price}}</td>
                            <td>{{$so->amount}}</td>
                            <td>{{ \Carbon\Carbon::parse($so->created_at)->subDays(1)->format('j, F, Y')}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>   
                </div> 
            </div>
        </div>
    </div>
</div>
@include('player.popups.buyOrderForm')
@include('player.popups.sellOrderForm')


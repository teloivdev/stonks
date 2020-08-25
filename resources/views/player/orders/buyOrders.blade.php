<div class="col-3">
    <h3>Open Buy Orders</h3>
    @foreach ($buyOrders as $bo)
        <p class="centerCenter">${{$bo->price}} Amount: {{$bo->available_amount}}</p>
    @endforeach
</div>
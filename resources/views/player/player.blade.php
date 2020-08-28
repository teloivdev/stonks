@include('static.head')
@include('static.nav')
<div style="position: absolute; top: 15%; left: 5%;" class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="pageUpdateToast">
  <div class="toast-header">
    <strong class="mr-auto">Page Updated!</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
@include('player.playerInfo')

    <script>
var channel = window.Echo.channel('price');
channel.listen('PriceHistoryCreated', function(data) {
    if (data.player_id == {{$player->id}})
    {
      var price = data.ph.price;
      var currentPrice = document.getElementById('currentPrice');
      var buyPrice = document.getElementById('buyPrice');
      var sellPrice = document.getElementById('sellPrice');

      currentPrice.innerHTML = price;
      buyPrice.value = price;
      sellPrice.value = price;
      
      getChart();
      $('#pageUpdateToast').toast({animation : true, delay : 1000, autohide : true});
      $('#pageUpdateToast').toast('show');
    }
});
channel.listen('BuyOrderCreated', function(data) {
  console.log(data);
  if (data.player_id == {{$player->id}})
  {
    var buyOrderList = document.getElementById('buyOrderList');
    var buyOrderTable = document.getElementById('buyOrderTable');
    var html = '';
    data.buyOrders.forEach(function(bo) {
      //html += '<p class="centerCenter">$' + bo.price + ' Amount: ' + bo.available_amount + '</p>';
      html += '<tr style="color: white;"><td>$' + data.price + '</td><td>' + data.available_amount + '</td></tr>';
    });

    buyOrderTable.innerHTML = html;
    $('#pageUpdateToast').toast({animation : true, delay : 1000, autohide : true});
    $('#pageUpdateToast').toast('show');
  }
});
channel.listen('SellOrderCreated', function(data) {
  console.log(data);
  if (data.player_id == {{$player->id}})
  {
    var sellOrderList = document.getElementById('sellOrderList');
    var sellOrderTable = document.getElementById('sellOrderTable');

    var html = '';
    data.sellOrders.forEach(function(so) {
      html += '<tr style="color: white;"><td>$' + data.price + '</td><td>' + data.available_amount + '</td></tr>';
    });

    sellOrderTable.innerHTML = html;
    $('#pageUpdateToast').toast({animation : true, delay : 1000, autohide : true});
    $('#pageUpdateToast').toast('show');
  }
});
</script>
@include('static.footer')

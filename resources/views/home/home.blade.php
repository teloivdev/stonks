@include('static.head')
@include('static.nav')
<!--<div class="card-body"> !-->
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-activeOrders-tab" data-toggle="pill" href="#pills-unfilledOrders" role="tab" aria-controls="pills-activeOrders" aria-selected="true">Active Orders</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-filledOrders-tab" data-toggle="pill" href="#pills-filledOrders" role="tab" aria-controls="pills-filledOrders" aria-selected="false">Filled Orders</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
  </li>
</ul>
<div class="tab-content" id="pills-topTabContent">
    <div class="tab-pane fade show active" id="pills-unfilledOrders" role="tabpanel" aria-labelledby="pills-home-tab">
        <ul class="nav nav-pills mb-3" id="pills-tab-sub" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-unfilledSellOrders-tab" data-toggle="pill" href="#pills-unfilledBuyOrders" role="tab" aria-controls="pills-home" aria-selected="true">Buy Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-unfilledBuyOrders-tab" data-toggle="pill" href="#pills-unfilledSellOrders" role="tab" aria-controls="pills-profile" aria-selected="false">Sell Orders</a>
            </li>
        </ul>
        @include('home.unfilledOrders')
    </div>
  <div class="tab-pane fade" id="pills-filledOrders" role="tabpanel" aria-labelledby="pills-profile-tab">
  <ul class="nav nav-pills mb-3" id="pills-tab-sub2" role="tablist">
    <li class="nav-item">
        <a onclick="setPageOne();" class="nav-link active" id="pills-filledSellOrders-tab" data-toggle="pill" href="#pills-filledBuyOrders" role="tab" aria-controls="pills-home" aria-selected="true">Buy Orders</a>
    </li>
    <li class="nav-item">
        <a onclick="setPageOne();" class="nav-link" id="pills-filledBuyOrders-tab" data-toggle="pill" href="#pills-filledSellOrders" role="tab" aria-controls="pills-profile" aria-selected="false">Sell Orders</a>
    </li>
  </ul>
        @include('home.filledOrders')
  </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
</div>
<script type="text/javascript">
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
});

var activeTab = localStorage.getItem('activeTab');
if(activeTab){
    $('.nav-pills a[href="' + activeTab + '"]').tab('show');
}
      
</script>
@include('static.footer')

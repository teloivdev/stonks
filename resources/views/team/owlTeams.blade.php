@include('static.head')
@include('static.nav')

<div class="container">
    <div class="row">
        <div class="col" style="text-align: center;">
            <h3>Overwatch League Teams</h3>
        </div>
    </div>
</div>
<div class="container-fluid">
@foreach ($teams as $t)
        @if (($loop->iteration - 1) % 3 == 0)
        <div class="row">
        @endif
            <div class="col-md colPop" style="padding:1%; border:1px solid gray; margin: 1%;">
            <a class="coolLinks" href="/overwatch/team/{{$t->id}}">{{$t->name}}
                <div class="row">
                <div class="col-md col-sm centerCenter">
                    <h5>Today</h5>
                    <h3>{{$t->currentAveragePrice}}</h3>
                </div>
                    <div class="col-md col-sm owlLogoContainer">
                        <img src="{{ asset('images/owl/' . $t->name . '.png') }}" class="owlLogos {{$t->name}}"/>
                    </div>
                    <div class="col-md col-sm centerCenter">
                        <h5>24/hr Change</h5>
                        <h3><i class="arrow {{$t->arrow}}"></i> {{$t->priceDiff}}</h3>
                    </div>
                </div>
                </a>
            </div>
        @if (($loop->iteration) % 3 == 0)
            </div>
        @endif
    @endforeach
</div>
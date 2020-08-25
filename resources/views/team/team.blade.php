@include('static.head')
@include('static.nav')

<div class="container">
    <div class="row">
    <div class="col-md"></div>
        <div class="col-md" style="text-align: center;">
            <h1>{{$team->name}}</h1>
        </div>
    <div class="col-md"></div>
    </div>
</div>
<div class="container">
@foreach ($players as $p)
        @if (($loop->iteration - 1) % 3 == 0)
        <div class="row no-gutters">
        @endif
            <div class="col-md col-sm playerContainer links">
            <a href="/overwatch/player/{{$p->id}}">
                <h2>{{$p->handle}}</h2>
                <p>{{$p->role}}</p>
                <img src="{{$p->portrait}}" style="width: 100%;"/>
                <h3 class="priceContainer">{{$p->last_price}} <i class="arrow {{$p->arrow}}"></i> {{$p->priceDiff}}</h3>
            </a>
            </div>
        @if ($loop->last)
            <div class="col-md col-sm"></div><div class="col-md col-sm"></div><div class="col-md col-sm"></div>
        @endif
        @if (($loop->iteration) % 3 == 0)
        </div>
        @endif
    @endforeach
</div>
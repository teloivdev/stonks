<nav class="navbar navbar-expand-sm navbar-dark bg-faded">
  <a class="navbar-brand" href="/">Stonks &#x21c5;</a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navCollapse">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="/overwatch">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/overwatch/owl">OWL Teams</a>
    </li>

    @if (Route::has('login'))
        @auth
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/home') }}">Profile</a>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        @endauth
        @if (Auth::check())
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/logout') }}"> logout </a>
        </li>
        @endif
    @endif
    </ul>
    <form class="form-inline my-2 my-lg-0">
        @csrf
        <input style="width: 20em;" type="text" id="searchPlayer" name="search" placeholder="Search A Player" class="form-control"/>
    </form>
  </div>
</nav>
<body class="darkMode">
<script type="text/javascript">

$(function () {
           $('#searchPlayer').autocomplete({
               source:function(request,response){
                
                   $.getJSON('/overwatch/player/search/autocomplete?search='+request.term,function(data){
                        var array = $.map(data,function(row){                            
                            return {
                                value:row.id,
                                label:row.handle + ' | Team: ' + row.team
                            }
          
                        })

                        response($.ui.autocomplete.filter(array,request.term));
                   })
               },
               minLength:1,
               delay:100,
               select:function(event,ui){
                    var base = "{{url('/')}}";
                    var getUrl = window.location;
                    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                    window.location.href = base + '/overwatch/player/' + ui.item.value;
                }
           })
});

</script>
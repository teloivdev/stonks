@include('static.head')
@include('static.nav')
<div class="container">
    <div class="col-md"></div>

    <div class="col-md">
        <form>
            @csrf
            <input type="text" id="playerHandle" name="playerHandle" placeholder="Player Name" class="form-control"/>
            <input type="submit" value="submit" class="btn btn-primary"/>
    </div>

    <div class="col-md"></div>


</div>
<script type="text/javascript">
$(function () {
           $('#playerHandle').autocomplete({
               source:function(request,response){
                
                   $.getJSON('search/autocomplete?playerHandle='+request.term,function(data){
                        var array = $.map(data,function(row){
                            return {
                                value:row.id,
                                label:row.handle
                            }
                        })

                        response($.ui.autocomplete.filter(array,request.term));
                   })
               },
               minLength:1,
               delay:500,
               select:function(event,ui){
                   $('#name').val(ui.item.label);
                   window.location = '/player/' + ui.item.value;
               }
           })
})
        </script>
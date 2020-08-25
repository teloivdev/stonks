<canvas id="chart" width="100%" height="50%"></canvas>
<script type="text/javascript">

var ctx = document.getElementById('chart').getContext('2d');
var lastWeek = '/overwatch/player/price/graph/lastWeek/{{$player->id}}';
var lastTrades = '/overwatch/player/price/graph/lastTrades/{{$player->id}}';

getChart();
/*
setInterval(() => {
    getChart();
}, 3000);
*/
function getChart() {
$.ajax({
    type:'get',
    url: lastTrades,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success:function(res) {
        var priceSet = [];
        var dateSet = [];
        var tradeNum = [];
        var options = {  weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        for (var i = 0; i < res.length; i++)
        {
            priceSet.push(res[i].price);
            tradeNum.push(i + 1);

        }
        for (var i = 0; i < res.length; i++)
        {
            newDate = new Date(res[i].created_at);
            var formatDate = (newDate.getMonth() + 1) + '/' + newDate.getDate() + '/' +  newDate.getFullYear();
            if (dateSet.indexOf(formatDate) === -1)
            {
                dateSet.push(formatDate);
            }
        }
        var ctx = document.getElementById("chart");
            var myBarChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels : tradeNum,
                    datasets: [{
                        label: 'Price',
                        data: priceSet,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255,99,132,1)'
                        ],
                        borderWidth: 1
                    }],
                }
            });
    },
    error:function(res) {
        console.log(res);
    }  
});
}
</script>


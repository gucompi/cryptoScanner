<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>
<body>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <?php
        require 'binance-api-single.php';
        $api = new Binance("public","private");

        // Get latest price of all symbols
        $tickers = $api->prices();
        $cryptosSeguidas = ['AAVEUSDT','ADAUSDT','ALPHAUSDT','ANKRUSDT','BAKEBUSD','BATUSDT','BLZUSDT','BNBUSDT','BTCUSDT','CAKEUSDT','COMPUSDT','DASHUSDT','DODOUSDT','DOGEUSDT','DOTUSDT','ENJUSDT','EOSUSDT','ETHUSDT','FRONTBUSD','IOTAUSDT','KAVAUSDT','LINKUSDT','LITUSDT','LTCUSD','LTCUSDT','LUNAUSDT','MANAUSDT','MFTUSDT','NEOUSDT','OCEANUSDT','REEFUSDT','RVNUSDT','SANDUSDT','SCUSDT','SUSHIUSDT','SXPUSDT','THETAUSDT','TRXUSDT','TWTUSDT','UNIUSDT','VETUSDT','WINGUSDT','XLMUSDT','XMRUSDT','XRPUSDT','XVSUSDT','YFIUSDT']
        ?>

        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Variacion Semanal ( % )</th>
                <th>Variacion Mensual ( % )</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $arr_keys = [];
            $arr_prices = [];
            foreach($tickers as $key => $price){
                if(in_array($key,$cryptosSeguidas)){
                    $candlesticks = $api->candlesticks($key);
                    $price1Week = $candlesticks[sizeof($candlesticks)-1][1];
                    $porcentajeCambio = (( $price * 100 ) / $price1Week) - 100;

                    array_push($arr_keys,$key);
                    array_push($arr_prices,$price);

                    $candlesticksM = $api->candlesticksMonth($key);
                    $price1Month = $candlesticksM[sizeof($candlesticksM)-1][1];
                    $porcentajeCambioM = (( $price * 100 ) / $price1Month) - 100;

                    echo '<tr><td>'.$key.'</td><td>'.$price.'</td><td> '.round($porcentajeCambio,2).'</td><td>'.$porcentajeCambioM.'</td></tr>';
                }
            }

            ?>
        <tbody>
    </table>
    <canvas id="myChart" width="400" height="400"></canvas>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_values($arr_keys)) ?>,
        datasets: [{
            label: '# of Votes',
            data: <?php json_encode(array_values($arr_prices)) ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script >
    $(document).ready(function() {
        $('#example').DataTable();
    } );
    </script>
</body>
</html>
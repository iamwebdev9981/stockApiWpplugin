<?php 


/***
 ---------------------------------------------------
     GET TABLE DATA  
 ---------------------------------------------------
 ***/

function __getTableData($table){
  if($table){
    global $wpdb,$table_prefix;
    $wp_stock_overview = $table_prefix.$table;
    $result = $wpdb->get_results("SELECT * FROM $wp_stock_overview");

    if($result){
      return $result;
    }else{
     echo "Data Not Found.";
    }
    }else{
    echo "Enter your table name";
  }  
}


/***
 ---------------------------------------------------
     GET ROW DATA  
 ---------------------------------------------------
 ***/


function __getRowData($table,$id){
  if($table){
    if($id){
      global $wpdb,$table_prefix;
      $wp_stock_overview = $table_prefix.$table;
      $result = $wpdb->get_row("SELECT * FROM $wp_stock_overview where id=".$id." ");

      if($result){
        return $result;
      }else{
       echo "Data Not Found.";
      }
    }else{
      echo "Please Enter Your Id Here.";
    }
  }else{
    echo "Please Enter Your Table Name.";
  }  
}



/***
 ---------------------------------------------------
     GET NIFTY VALUE LIVE 
 ---------------------------------------------------
 ***/

 function __getLiveNifty($url,$symbol){


 // $url = "https://query1.finance.yahoo.com/v7/finance/chart/^NSEI?range=1d&interval=1m";
$data = file_get_contents($url);
$json = json_decode($data, true);

$current_price = $json['chart']['result'][0]['meta']['regularMarketPrice'];
$change = $json['chart']['result'][0]['meta']['regularMarketChange'];
$percent_change = $json['chart']['result'][0]['meta']['regularMarketChangePercent'];

if ($change > 0) {
  $change_indicator = "+";
  $trend_indicator = "📈";
} elseif ($change < 0) {
  $change_indicator = "";
  $trend_indicator = "📉";
} else {
  $change_indicator = "";
  $trend_indicator = "🔷";
}

echo "<span>Nifty 50 : </span><span>" . $current_price . "</span><br>";
echo "<span>Change : " . $change_indicator . $change . " (" . $percent_change . "%) " . $trend_indicator . "</span>";

 }


 /***
 ---------------------------------------------------
     GET SENSEX VALUE LIVE 
 ---------------------------------------------------
 ***/

 function __getLiveSensex($url,$symbol){

//$url = "https://query1.finance.yahoo.com/v7/finance/chart/^BSESN?range=1d&interval=1m";
$data = file_get_contents($url);
$json = json_decode($data, true);

$current_price = $json['chart']['result'][0]['meta']['regularMarketPrice'];
$change = $json['chart']['result'][0]['meta']['regularMarketChange'];
$percent_change = $json['chart']['result'][0]['meta']['regularMarketChangePercent'];

if ($change > 0) {
  $change_indicator = "+";
  $trend_indicator = "📈";
} elseif ($change < 0) {
  $change_indicator = "";
  $trend_indicator = "📉";
} else {
  $change_indicator = "";
  $trend_indicator = "🔷";
}

echo "<span>Sensex : </span><span>" . $current_price . "</span></br>";
echo "<span>Change : " . $change_indicator . $change . " (" . $percent_change . "%) " . $trend_indicator . "</span>";


 }


   /***
 ---------------------------------------------------
     GET NIFTY 100 VALUE LIVE 
 ---------------------------------------------------
 ***/

 function __getNifty100($url,$symbol){

//$url = "https://query1.finance.yahoo.com/v7/finance/chart/^NSEI?range=1d&interval=1m";
$data = file_get_contents($url);
$json = json_decode($data, true);

$current_price = $json['chart']['result'][0]['meta']['regularMarketPrice'];
$change = $json['chart']['result'][0]['meta']['regularMarketChange'];
$percent_change = $json['chart']['result'][0]['meta']['regularMarketChangePercent'];

if ($change > 0) {
  $change_indicator = "+";
  $trend_indicator = "📈";
} elseif ($change < 0) {
  $change_indicator = "";
  $trend_indicator = "📉";
} else {
  $change_indicator = "";
  $trend_indicator = "🔷";
}

echo "<span>Nifty 100 : </span><span>" . $current_price . "</span><br>";
echo "<span>Change: " . $change_indicator . $change . " (" . $percent_change . "%) " . $trend_indicator . "</span>";

 }


  /***
 ---------------------------------------------------
     GET BANK NIFTY VALUE LIVE 
 ---------------------------------------------------
 ***/

 function __getBankNifty($url,$symbol){

//$url = "https://query1.finance.yahoo.com/v7/finance/chart/^NSEBANK?range=1d&interval=1m";
$data = file_get_contents($url);
$json = json_decode($data, true);

$current_price = $json['chart']['result'][0]['meta']['regularMarketPrice'];
$change = $json['chart']['result'][0]['meta']['regularMarketChange'];
$percent_change = $json['chart']['result'][0]['meta']['regularMarketChangePercent'];

if ($change > 0) {
  $change_indicator = "+";
  $trend_indicator = "📈";
} elseif ($change < 0) {
  $change_indicator = "";
  $trend_indicator = "📉";
} else {
  $change_indicator = "";
  $trend_indicator = "🔷";
}

echo "<span>Bank Nifty: </span><span>" . $current_price . "</span></br>";
echo "<span>Change: " . $change_indicator . $change . " (" . $percent_change . "%) " . $trend_indicator . "</span>";

 }


/***
 ---------------------------------------------------
     GET NIFTY IT VALUE LIVE 
 ---------------------------------------------------
 ***/

 function __getNiftyIT($url,$symbol){

//$url = "https://query1.finance.yahoo.com/v7/finance/chart/^NIFTYIT?range=1d&interval=1m";
$data = file_get_contents($url);
$json = json_decode($data, true);

$current_price = $json['chart']['result'][0]['meta']['regularMarketPrice'];
$change = $json['chart']['result'][0]['meta']['regularMarketChange'];
$percent_change = $json['chart']['result'][0]['meta']['regularMarketChangePercent'];

if ($change > 0) {
  $change_indicator = "+";
  $trend_indicator = "📈";
} elseif ($change < 0) {
  $change_indicator = "";
  $trend_indicator = "📉";
} else {
  $change_indicator = "";
  $trend_indicator = "🔷";
}

echo "<span>Nifty IT : </span><span>" . $current_price . "</span><br>";
echo "<span>Change: " . $change_indicator . $change . " (" . $percent_change . "%) " . $trend_indicator . "</span>";


 }


 /***
 ---------------------------------------------------
     GET NIFTY PHARMA VALUE LIVE 
 ---------------------------------------------------
 ***/

 function __getNiftyPharma($url,$symbol){

//$symbol = "^CNXPHARMA"; // The symbol for Nifty Pharma index
//$url = "https://query1.finance.yahoo.com/v7/finance/chart/$symbol?range=1d&interval=1m";

$json = file_get_contents($url);
$data = json_decode($json, true);

// Get the current value and previous value of the index
$current_value = end($data['chart']['result'][0]['indicators']['quote'][0]['close']);
$previous_value = prev($data['chart']['result'][0]['indicators']['quote'][0]['close']);

// Calculate the percentage change
$percentage_change = round((($current_value - $previous_value) / $previous_value) * 100, 2);

// Check if the value has increased or decreased
$indicator = '';
if ($current_value > $previous_value) {
    $indicator = '↑';
} else if ($current_value < $previous_value) {
    $indicator = '↓';
}

$current_value_f =  number_format($current_value,2);

// Output the results
echo "<span>Nifty Pharma: </span><span>$current_value_f($indicator$percentage_change%)</span>";

 }


 /***
 ---------------------------------------------------
     GET NIFTY DATA WITH HIGHCHART
 ---------------------------------------------------
 ***/

function ___showNiftyChart($url,$symbol){

//$symbol = "^NSEI"; // Nifty symbol
//url = "https://query1.finance.yahoo.com/v7/finance/chart/$symbol?range=1d&interval=1m"; // API URL

// Make API request
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_SSL_VERIFYPEER => false,
));
$response = curl_exec($curl);
curl_close($curl);

// Parse JSON response
$data = json_decode($response, true);
$timestamp = $data['chart']['result'][0]['timestamp'];
$prices = $data['chart']['result'][0]['indicators']['quote'][0]['close'];

// Generate chart data
$rows = array();
foreach ($timestamp as $key => $value) {
  $date = date('Y-m-d H:i:s', $value);
  $rows[] = array($value * 1000, $prices[$key]);
}

// Generate chart options
$options = array(
  'chart' => array(
    'type' => 'line',
  ),
  'title' => array(
    'text' => $symbol.' Nifty Stock Price',
  ),
  'xAxis' => array(
    'type' => 'datetime',
  ),
  'yAxis' => array(
    'title' => array(
      'text' => 'Price (INR)',
    ),
  ),
  'series' => array(
    array(
      'name' => 'Price',
      'data' => $rows,
    ),
  ),
);

// Generate chart script
$optionsJson = json_encode($options);
$chartScript = "Highcharts.chart('chart-container', $optionsJson);";

// Display chart
echo "<div id='chart-container' style='width: 100%; height: 300px;'></div>";
echo "<script>$chartScript</script>";

}




/***
 ---------------------------------------------------
     FUNCTION FOR SHOW CHART WITH HIGHCHART  
 ---------------------------------------------------
 ***/

function __showChart($url,$symbol,$name,$chartType,$chart_id){

// Initialize cURL
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Decode the JSON response
$data = json_decode($response, true);

// Get the candlestick data
$timestamps = $data['chart']['result'][0]['timestamp'];
$openPrices = $data['chart']['result'][0]['indicators']['quote'][0]['open'];
$highPrices = $data['chart']['result'][0]['indicators']['quote'][0]['high'];
$lowPrices = $data['chart']['result'][0]['indicators']['quote'][0]['low'];
$closePrices = $data['chart']['result'][0]['indicators']['quote'][0]['close'];

// Format the data for Highcharts
$candlestickData = array();
for ($i = 0; $i < count($timestamps); $i++) {
    $timestamp = $timestamps[$i];
    $openPrice = $openPrices[$i];
    $highPrice = $highPrices[$i];
    $lowPrice = $lowPrices[$i];
    $closePrice = $closePrices[$i];
    $candlestickData[] = array($timestamp * 1000, $openPrice, $highPrice, $lowPrice, $closePrice);
}


echo '<div id="container'.$chart_id.'"></div>';
echo '<script>';
echo 'Highcharts.stockChart("container'.$chart_id.'", {
    rangeSelector: {
        selected: 6
    },
    title: {
        text: "'. $symbol.'"
    },

    yAxis: {
        labels: {
            formatter: function () {
                return "$" + this.value;
            }
        }
    },
   

    series: [{
        type: "'.$chartType.'",
        name: "'.$symbol.'",
        data: ' . json_encode($candlestickData) . ',
        tooltip: {
            valueDecimals: 2
        }
    }]
});';
echo '</script>';

}



/***
 ---------------------------------------------------
     AJAX FUNCTION FOR FETCH DATA  
 ---------------------------------------------------
 ***/



 ?>
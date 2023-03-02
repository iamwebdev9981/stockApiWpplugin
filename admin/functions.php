<?php 


/***
 ---------------------------------------------------
     GET TABLE DATA  
 ---------------------------------------------------
 ***/


 function __getData(){

 }


 /***
 ---------------------------------------------------
     GET ROW DATA  
 ---------------------------------------------------
 ***/

 function __getRowData($table_name,$id){

  global $wpdb,$table_prefix;
  $wp_stock_overview = $table_prefix.$table_name;

  $result = $wpdb->get_row("SELECT * FROM $wp_stock_overview WHERE id='".$stock_id."' ");
  if($res){
  	return $result;
  }else{
  	$query_msg = "Data Not Found.";
  	return $query_msg;
  }


 }



/***
 ---------------------------------------------------
     FUNCTION FOR SHOW CHART WITH HIGHCHART  
 ---------------------------------------------------
 ***/

function __showChart($url,$symbol,$chartType,$chart_id){

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
        selected: 5
    },
    title: {
        text: "'. $symbol.' Chart"
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
        color:"red",
        name: "'.$symbol.'",
        data: ' . json_encode($candlestickData) . ',
        tooltip: {
            valueDecimals: 2
        }
    }]
});';
echo '</script>';

}



 ?>
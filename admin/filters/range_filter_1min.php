<?php 
require_once('../../../../../wp-config.php');
global $wpdb,$table_prefix;
$wp_stock_overview = $table_prefix.'stock_overview';

if(isset($_POST['id'])){
    $id              = $_POST['id'];
    $page_no         = $_POST['page_no'];
    $filter_val      = $_POST['filter_val'];
    $filter_interval = $_POST['filter_interval'];

$res2 = $wpdb->get_row("SELECT * FROM $wp_stock_overview WHERE id='".$id."' ");

$repl_url_int =  str_replace("1d",$filter_interval,$res2->content);
$repl_url     =  str_replace("24mo",$filter_val,$repl_url_int);

$url2 = $repl_url;

$curl_handle2 = curl_init();

curl_setopt($curl_handle2, CURLOPT_URL, $url2);

curl_setopt($curl_handle2, CURLOPT_RETURNTRANSFER, true);

$curl_data2 = curl_exec($curl_handle2);

curl_close($curl_handle2);

$response_data2 = json_decode($curl_data2);


$data2     = $response_data2->chart;
$result2   = $data2->result;
$curl_err2 = $data2->error;


if(isset($curl_err2)){
   //echo $curl_err->code;
   echo'<div class="container er_container text-center">
   <p class="display-4">
   '.$curl_err->code.'</p><p>'.$curl_err2->description.'</p>
   <a class="close_btn pb-2 text-center" href="'.STX_ADMIN_URL.'admin.php?page=dashboard&pageno='.$page_no.'" title="">Go Back</a></div>';
   exit();
}

   $response2 = file_get_contents($url2);
   $data2 = json_decode($response2, true);

// Access the stock data from the response
$timestamps2 = $data2['chart']['result'][0]['timestamp'];
$closePrices2 = $data2['chart']['result'][0]['indicators']['quote'][0]['close'];

// Format the data for the chart
$dates2 = [];
$prices2 = [];
for ($i = 0; $i < count($timestamps2); $i++) {
    $dates2[] = date("Y-m-d", $timestamps2[$i]);
    $prices2[] = $closePrices2[$i];
}

// Load the Google Charts library
echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';

// Draw the chart
echo '<script type="text/javascript">
      google.charts.load("current", {"packages":["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Date", "Close Price"],
          ';

for ($i = 0; $i < count($dates2); $i++) {
    echo '["' . $dates2[$i] . '", ' . $prices2[$i] . '],' . PHP_EOL;
}

echo ']);
        var options = {
          title: "Stock Chart for '.$res2->symbol.' ",
          curveType: "function",
          colors: ["#0bcd73"],
          legend: { position: "bottom" },
          vAxis : { 
          textStyle : {
            fontSize: 12,
            color:"#000",
          }},
          hAxis : { 
          textStyle : {
            fontSize: 10,
            color:"#000",
          }
         }

        };
        var chart = new google.visualization.LineChart(document.getElementById("curve_chart'.$id.'"));
        chart.draw(data, options);
      }
    </script>';

}


 ?>
 <div id="curve_chart<?php echo $id  ?>" style="width: auto; height: 500px"></div>
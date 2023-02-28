<?php 
  global $wpdb,$table_prefix;
  $wp_stock_overview = $table_prefix.'stock_overview';

  $res = $wpdb->get_row("SELECT * FROM $wp_stock_overview WHERE id=2 ");

  $url = "".$res->content."";

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
		<!-- Added custom css file -->
	<link rel="stylesheet" href="<?php echo STX_PLUGIN_URL.'/stock_overview/admin/css/templates.css' ?>">
	<!-- Added bootstrap css cdn file -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- Added bootstrap js cdn file -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- Added fontawesome cdn file -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Added Jquery cdn file -->
	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light p-2 px-3">
  <div class="container-fluid">
    <a class="navbar-brand ml-5" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions" href=""><i class="fa fa-bars"></i></a>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Backdroped with scrolling</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <p>Try scrolling the rest of the page to see this option in action.</p>
  </div>
</div>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link"  href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Symbol</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="#">Chart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" >Explore</a>
        </li>
      </ul>
      <div class="d-flex">
        <input class="form-control me-2 shadow-none" type="text" placeholder="Search" id="search">
      </div>
    </div>
  </div>
</nav>


<!-- <div class="container-fluid p-4">
<div class="row mt-5">
<div class="col-sm-12 col-lg-9 col-md-9 ">
<div class="border rounded border-light shadow-sm p-3">
<?php 


// Set the URL for the Yahoo Finance API
//$url = '';

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

// Generate the candlestick chart using Highcharts
echo '<html>';
echo '<head>';
// echo '<script src="https://code.highcharts.com/highcharts.js"></script>';
// echo '<script src="https://code.highcharts.com/modules/exporting.js"></script>';
// echo '<script src="https://code.highcharts.com/modules/export-data.js"></script>';

echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.6/css/highcharts.css" />';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.6/js/highstock.js"></script>';

echo '</head>';
echo '<body>';
echo '<div id="container"></div>';
echo '<script>';
echo 'Highcharts.stockChart("container", {
    rangeSelector: {
        selected: 1
    },
    title: {
        text: "'. $res->symbol.' Historical Price"
    },
    yAxis: {
        labels: {
            formatter: function () {
                return "$" + this.value;
            }
        }
    },
    series: [{
        type: "candlestick",
        name: "'.$res->symbol.'",
        data: ' . json_encode($candlestickData) . ',
        tooltip: {
            valueDecimals: 2
        }
    }]
});';
echo '</script>';
echo '</body>';
echo '</html>';


?>
</div>			
</div>

		<div class="col-sm-12 col-lg-3 col-md-3">
			<div class="border rounded border-light shadow-sm p-3">
				
			</div>
		</div>
	</div>
</div> -->

<div class="" id="result"></div>

<script> 
      $(document).ready(function() {
        $("#search").keyup(function() {
          var searchTerm = $(this).val();
          //alert(searchTerm);

          $.ajax({
            type: "POST",
            url: "<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/search_filter_frontend.php'; ?>",
            data: {
              search: searchTerm
            },
            success: function(data) {
              $("#result").html(data);
              //alert(data);
                
            }
          });
        });
      });
    </script>
	
</body>
</html>
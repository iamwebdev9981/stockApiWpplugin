<?php include('header.php');
  global $wpdb,$table_prefix;
  $wp_stock_overview = $table_prefix.'stock_overview';

    if(@$_GET['id']){

    $id = $_GET['id'];
    $page_no = @$_GET['pageno'];

    $res = $wpdb->get_row("SELECT * FROM $wp_stock_overview WHERE id='".$id."' ");


if($res->content == ''){
  echo $res->content;
}else{

    
// Retrieve the stock data from the API
$url = "".$res->content."";

$curl_handle = curl_init();

curl_setopt($curl_handle, CURLOPT_URL, $url);

curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

$curl_data = curl_exec($curl_handle);

curl_close($curl_handle);

$response_data = json_decode($curl_data);


$data     = $response_data->chart;
$result   = $data->result;
$curl_err = $data->error;


if(isset($curl_err)){
   //echo $curl_err->code;
   echo'<div class="container er_container text-center">
   <p class="display-4">
   '.$curl_err->code.'</p><p>'.$curl_err->description.'</p>
   <a class="close_btn pb-2 text-center" href="'.STX_ADMIN_URL.'admin.php?page=dashboard&pageno='.$page_no.'" title="">Go Back</a></div>';
   exit();
}


$response = file_get_contents($url);
$data = json_decode($response, true);

// Access the stock data from the response
$timestamps = $data['chart']['result'][0]['timestamp'];
$meta = $data['chart']['result'][0]['meta'];
$closePrices = $data['chart']['result'][0]['indicators']['quote'][0]['close'];

$dates = [];
$prices = [];
for ($i = 0; $i < count($timestamps); $i++) {
    $dates[] = date("Y-m-d", $timestamps[$i]);
    $prices[] = $closePrices[$i];
}

?>



    <div class="container mt-4">
        <div class="d-flex justify-content-between">
           <h6 class="single_chart_title"><?php echo $res->name ?></h6><a class="close_btn" href="<?php echo STX_ADMIN_URL.'admin.php?page=dashboard&pageno='.$page_no ;?>">Go Back</a>
        </div>
        <div class="">
            <p>
               <strong class="title-h">SECTOR</strong> - <span class="title-desc"><?php echo $res->sector ?></span><br>
               <strong class="title-h">SYMBOL</strong> - <span class="title-desc"><?php echo $res->symbol ?></span><br>
               <strong class="title-h">REGULAR MARKET PRICE</strong> - <span class="title-desc"><?php echo $meta['regularMarketPrice']; ?></span><br>
            </p>
        </div>
        
    </div>


<div class="container"><!-- Start chart -->
<?php 

// --------------------------------------------------------------



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





//----------------------------------------------------------------

?>
</div><!-- close chart -->


<div class="" id="filter_data1"></div>


<script>
    $(document).ready(function(){
        $('#fltr_btn_1m').click(function(){
            var id              = <?php echo $id ?>;
            var page_no         = <?php echo $page_no ?>;
            var filter_val      = '3m';
            var filter_interval = '1m';

            $.ajax({
                type:"POST",
                url:"<?php echo STX_FULL_PLUGIN_URL.'admin/filters/range_filter_1min.php'; ?>",
                data:{id:id, page_no:page_no, filter_val:filter_val, filter_interval:filter_interval},
                success:function(data1){
                    if(data1){
                       //alert(data1);
                       $('#curve_chart').css({"display":"none"});
                       $('#filter_data1').html(data1);
                       $('#fltr_btn_1m').addClass('bg-success text-white');
                       $('#fltr_btn_1mo').removeClass('bg-success text-white');
                       $('#fltr_btn_6mo').removeClass('bg-success text-white');
                       $('#fltr_btn_1y').removeClass('bg-success text-white');
                       $('#fltr_btn_3y').removeClass('bg-success text-white');
                       $('#fltr_btn_5y').removeClass('bg-success text-white');
                       $('#fltr_btn_all').removeClass('bg-success text-white');
                    }
    
                }
            });
           
        });

        $('#fltr_btn_1mo').click(function(){
            var id         = <?php echo $id ?>;
            var page_no    = <?php echo $page_no ?>;
            var filter_val = '1mo';

            $.ajax({
                type:"POST",
                url:"<?php echo STX_FULL_PLUGIN_URL.'admin/filters/range_filter.php'; ?>",
                data:{id:id, page_no:page_no, filter_val:filter_val},
                success:function(data1){
                    if(data1){
                       //alert(data1);
                       $('#curve_chart').css({"display":"none"});
                       $('#filter_data1').html(data1);
                       $('#fltr_btn_1m').removeClass('bg-success text-white');
                       $('#fltr_btn_1mo').addClass('bg-success text-white');
                       $('#fltr_btn_6mo').removeClass('bg-success text-white');
                       $('#fltr_btn_1y').removeClass('bg-success text-white');
                       $('#fltr_btn_3y').removeClass('bg-success text-white');
                       $('#fltr_btn_5y').removeClass('bg-success text-white');
                       $('#fltr_btn_all').removeClass('bg-success text-white');
                    }
    
                }
            });
           
        });

        $('#fltr_btn_6mo').click(function(){
            var id         = <?php echo $id ?>;
            var page_no    = <?php echo $page_no ?>;
            var filter_val = '6mo';

            $.ajax({
                type:"POST",
                url:"<?php echo STX_FULL_PLUGIN_URL.'admin/filters/range_filter.php'; ?>",
                data:{id:id, page_no:page_no, filter_val:filter_val},
                success:function(data1){
                    if(data1){
                       //alert(data1);
                       $('#curve_chart').css({"display":"none"});
                       $('#filter_data1').html(data1);
                       $('#fltr_btn_1m').removeClass('bg-success text-white');
                       $('#fltr_btn_1mo').removeClass('bg-success text-white');
                       $('#fltr_btn_6mo').addClass('bg-success text-white');
                       $('#fltr_btn_1y').removeClass('bg-success text-white');
                       $('#fltr_btn_3y').removeClass('bg-success text-white');
                       $('#fltr_btn_5y').removeClass('bg-success text-white');
                       $('#fltr_btn_all').removeClass('bg-success text-white');
                    }
    
                }
            });
           
        });


        $('#fltr_btn_1y').click(function(){
            var id         = <?php echo $id ?>;
            var page_no    = <?php echo $page_no ?>;
            var filter_val = '12mo';

            $.ajax({
                type:"POST",
                url:"<?php echo STX_FULL_PLUGIN_URL.'admin/filters/range_filter.php'; ?>",
                data:{id:id, page_no:page_no, filter_val:filter_val},
                success:function(data1){
                    if(data1){
                       //alert(data1);
                       $('#curve_chart').css({"display":"none"});
                       $('#filter_data1').html(data1);
                       $('#fltr_btn_1m').removeClass('bg-success text-white');
                       $('#fltr_btn_1mo').removeClass('bg-success text-white');
                       $('#fltr_btn_6mo').removeClass('bg-success text-white');
                       $('#fltr_btn_1y').addClass('bg-success text-white');
                       $('#fltr_btn_3y').removeClass('bg-success text-white');
                       $('#fltr_btn_5y').removeClass('bg-success text-white');
                       $('#fltr_btn_all').removeClass('bg-success text-white');
                    }
    
                }
            });
           
        });

        $('#fltr_btn_3y').click(function(){
            var id         = <?php echo $id ?>;
            var page_no    = <?php echo $page_no ?>;
            var filter_val = '36mo';

            $.ajax({
                type:"POST",
                url:"<?php echo STX_FULL_PLUGIN_URL.'admin/filters/range_filter.php'; ?>",
                data:{id:id, page_no:page_no, filter_val:filter_val},
                success:function(data1){
                    if(data1){
                       //alert(data1);
                       $('#curve_chart').css({"display":"none"});
                       $('#filter_data1').html(data1);
                       $('#fltr_btn_1m').removeClass('bg-success text-white');
                       $('#fltr_btn_1mo').removeClass('bg-success text-white');
                       $('#fltr_btn_6mo').removeClass('bg-success text-white');
                       $('#fltr_btn_1y').removeClass('bg-success text-white');
                       $('#fltr_btn_3y').addClass('bg-success text-white');
                       $('#fltr_btn_5y').removeClass('bg-success text-white');
                       $('#fltr_btn_all').removeClass('bg-success text-white');
                    }
    
                }
            });
           
        });

        $('#fltr_btn_5y').click(function(){
            var id         = <?php echo $id ?>;
            var page_no    = <?php echo $page_no ?>;
            var filter_val = '60mo';

            $.ajax({
                type:"POST",
                url:"<?php echo STX_FULL_PLUGIN_URL.'admin/filters/range_filter.php'; ?>",
                data:{id:id, page_no:page_no, filter_val:filter_val},
                success:function(data1){
                    if(data1){
                       //alert(data1);
                       $('#curve_chart').css({"display":"none"});
                       $('#filter_data1').html(data1);
                       $('#fltr_btn_1m').removeClass('bg-success text-white');
                       $('#fltr_btn_1mo').removeClass('bg-success text-white');
                       $('#fltr_btn_6mo').removeClass('bg-success text-white');
                       $('#fltr_btn_1y').removeClass('bg-success text-white');
                       $('#fltr_btn_3y').removeClass('bg-success text-white');
                       $('#fltr_btn_5y').addClass('bg-success text-white');
                       $('#fltr_btn_all').removeClass('bg-success text-white');
                    }
    
                }
            });
           
        });


        $('#fltr_btn_all').click(function(){
            var id         = <?php echo $id ?>;
            var page_no    = <?php echo $page_no ?>;
            var filter_val = 'max';

            $.ajax({
                type:"POST",
                url:"<?php echo STX_FULL_PLUGIN_URL.'admin/filters/range_filter.php'; ?>",
                data:{id:id, page_no:page_no, filter_val:filter_val},
                success:function(data1){
                    if(data1){
                       //alert(data1);
                       $('#curve_chart').css({"display":"none"});
                       $('#filter_data1').html(data1);
                       $('#fltr_btn_1m').removeClass('bg-success text-white');
                       $('#fltr_btn_1mo').removeClass('bg-success text-white');
                       $('#fltr_btn_6mo').removeClass('bg-success text-white');
                       $('#fltr_btn_1y').removeClass('bg-success text-white');
                       $('#fltr_btn_3y').removeClass('bg-success text-white');
                       $('#fltr_btn_5y').removeClass('bg-success text-white');
                       $('#fltr_btn_all').addClass('bg-success text-white');
                    }
    
                }
            });
           
        });

    
    });
</script>
   


<?php }}else{

   if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 132;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $total_pages_sql = $wpdb->get_var('SELECT COUNT(*) FROM wp_stock_overview ');
        
        $total_pages = ceil($total_pages_sql / $no_of_records_per_page);

        $results = $wpdb->get_results("SELECT * FROM wp_stock_overview LIMIT $offset, $no_of_records_per_page");

       if(!$results == ""){

 ?>


<!-- ----------------------------------------------------------------------------------------- -->

<?php // echo STX_FULL_PLUGIN_URL.'admin/search.php'; ?>
<script> 
      $(document).ready(function() {
        $("#search").keyup(function() {
          var searchTerm = $(this).val();
          $.ajax({
            type: "POST",
            url: "<?php echo STX_FULL_PLUGIN_URL.'admin/search.php'; ?>",
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

    

<?php  ?>

<div class="container mt-4 shadow-sm p-4">
<div class="d-flex justify-content-between container pb-3">
       <h5>Stock Symbol</h5>
       <div class="search-box " width="200px">
           <input type="text" class="form-control" id="search" placeholder="Search..">
       </div>       
    </div>
    <hr>
   <div id="result"></div>

   <div class="row">
    <?php  foreach($results as $value){ ?>
     <div class="col-sm-1 col-lg-1 col-md-2 p-0">
      <div class="symbol-box">
         <a href=""></a>
         <a  class="title" href="<?php echo STX_ADMIN_URL?>admin.php?page=dashboard&id=<?php echo $value->id; ?>&pageno=<?php echo $pageno; ?> "><?php echo $value->symbol;?></a>
      </div>
     </div>
    <?php } ?>

    <div class="pagination-box mt-3">
       <ul class="pagination">
            <li><a href="admin.php?page=dashboard&pageno=1" class="btn-outline-primary">First</a></li>
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "admin.php?page=dashboard&pageno=".($pageno - 1); } ?>"  class="btn-outline-primary"> Prev</a>
            </li>
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "admin.php?page=dashboard&pageno=".($pageno + 1); } ?>" class="btn-outline-primary">Next</a>
            </li>
            <li><a href="admin.php?page=dashboard&pageno=<?php echo $total_pages; ?>" class="btn-outline-primary">Last</a></li>
        </ul>
    </div>
   </div>
 </div>


<?php }else{?>

       <div class="container mt-5 p-4 text-center data-not-found">
        <h1 class=" display-2 ">No Data Found.</h1>
           <div class="img-box ">
            <img src="<?php echo STX_PLUGIN_URL.'/stock_overview/admin/img/data_not_found_1.png'?>" alt="">
           </div>
            <small>Go to the the add <a href="<?php echo STX_ADMIN_URL?>admin.php?page=add_stocks" class="">Stock</a> page</small>
       </div>

<?php }} ?>


<?php include('footer.php'); ?>
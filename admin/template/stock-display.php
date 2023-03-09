<?php 
  include('../functions.php');
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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.6/css/highcharts.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.6/js/highstock.js"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light p-2 px-3 ">
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
    <div class="collapse navbar-collapse " id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link"  href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="#"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" ></a>
        </li>
      </ul>
      <div class="right-div">
      	<div class="mr-5" id="nifty_value_box"></div>
        <input class="form-control me-2 shadow-none" type="text" placeholder="Search" id="search">
      </div>
    </div>
  </div>
</nav>

<div class="" id="result2"></div>

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
            success: function(searchData) {
              $("#result2").html(searchData);
              //alert(data);
                
            }
          });
        });
      });
    </script>


<div class="container">
	<?php 

  if(isset($_GET['chartType'])){
  if(!$_GET['chartType'] == ''){ ?>

  	 <div class="container p-2">
 	<div class="d-flex justify-content-between pt-3">
 		<div class="">
 			<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/?chartType=area" id="area-chart-btn" class="btn-sm btn-success text-decoration-none">Area Chart</a>
    				<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/?chartType=line" id="line-chart-btn" class="btn-sm btn-primary text-decoration-none">Line Chart</a>
    				<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/?chartType=candlestick" id="candlestick-chart-btn" class="btn-sm btn-danger text-decoration-none">Candlestick Chart</a>
 		</div>
 		<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/" class="text-decoration-none btn-sm btn-secondary">Go Back</a>
 	</div>

 	<div class="" id="chart"></div>
 </div>

   <?php  $chart_type = $_GET['chartType'];
   ?>
   <script>
   	   var chart_name = '<?php echo $chart_type; ?>';
   	 $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_main_chart.php'; ?>",
		      data:{cahart_status:1,chart_name:chart_name},
		      success:function(f_resp_main)
		      {
           $("#chart").html(f_resp_main);
		      }
		    });
   </script>

   <?php

  }else{
  	?>
      <div class="container m-5 p-5 text-center"><p class="display-4 mt-5 pt-5">Chart Name Not Found.</p>
      	<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/" class="text-decoration-none btn-sm btn-secondary">Go Back</a>
      </div>
  	<?php
  }


   




  /* else part of chart*/   
  }else{

	 ?>
</div>


    <div class="container-fluid mb-2 mt-3 ">
    	<div class="row p-3">
    		
    		<div class="col-sm-12 col-lg-8 col-md-8 ">
    			<div class="left-side-col">
    			<div class="container pb-2">
    			<div class="d-flex justify-content-center align-items-center">
    				<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/?chartType=area" id="area-chart-btn" class="btn-sm btn-success text-decoration-none mx-1">Area Chart</a>
    				<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/?chartType=line" id="line-chart-btn" class="btn-sm btn-primary text-decoration-none mx-1">Line Chart</a>
    				<a href="<?php echo site_url(); ?>/<?php echo basename(get_permalink()); ?>/?chartType=candlestick" id="candlestick-chart-btn" class="btn-sm btn-danger text-decoration-none mx-1">Candlestick Chart</a>
    			</div>
    		</div>


    			<div class="chart-box">
    				<div class="" id="dis-main-chart-1"></div>
    				<div class="" id="dis-main-chart-1f"></div>
    			</div>
    		</div>
    		</div>

    	<div class="col-sm-12 col-lg-4 col-md-4 right-side-col">
    	<div class="row row-1 mb-3 mt-3">
    		<div class="col-sm-6 col-lg-6 col-md-6 text-center">
    			<div class="nft-box">
    				<span id="nifty_value1"></span>
    				<span id="nifty_value"></span>
    			</div>
    		</div>
    		<div class="col-sm-6 col-lg-6 col-md-6 text-center">
    			<div class="nft-box ">
    				<span id="sensex_value1"></span>
    				<span id="sensex_value"></span>
    			</div>
    		</div>
    	</div>
    	<div class="row row-2 mb-3">
    		<div class="col-sm-6 col-lg-6 col-md-6 text-center">
    			<div class="nft-box ">
    				<span id="banknifty_value1"></span>
    				<span id="banknifty_value"></span>
    			</div>
    		</div>
    		<div class="col-sm-6 col-lg-6 col-md-6 text-center">
    			<div class="nft-box ">
    				<span id="nifty100_value1"></span>
    				<span id="nifty100_value"></span>
    			</div>
    		</div>
    	</div>	
    	<div class="row row-3 mb-3">
    		<div class="col-sm-6 col-lg-6 col-md-6 text-center">
    			<div class="nft-box ">
    				<span id="niftyIT_value1"></span>
    				<span id="niftyIT_value"></span>
    			</div>
    		</div>
    		<div class="col-sm-6 col-lg-6 col-md-6 text-center">
    			<div class="nft-box ">
    				<span id="niftyPharma_value1"></span>
    				<span id="niftyPharma_value"></span>
    			</div>
    		</div>
    	</div>
    		</div>
    	</div>
    </div>

<!--  -->
    <div class="container-fluid pt-2">
    	<div class="row top-chart-row">
    		<div class="col-sm-12 col-lg-2 col-md-2">
    			<div class="chart-box">
    				<div class="" id="dis-chart-1f"></div>
    				<div class="" id="dis-chart-1"></div>
    			</div>
    		</div>
    		<div class="col-sm-12 col-lg-2 col-md-2">
    			<div class="chart-box">
    				<div class="" id="dis-chart-2f"></div>
    				<div class="" id="dis-chart-2"></div>
    			</div>
    		</div>
    		<div class="col-sm-12 col-lg-2 col-md-2">
    			<div class="chart-box">
              <div class="" id="dis-chart-3f"></div>
              <div class="" id="dis-chart-3"></div>
    			</div>
    		</div>
    		<div class="col-sm-12 col-lg-2 col-md-2">
    			<div class="chart-box">
    				<div class="" id="dis-chart-4f"></div>
    				<div class="" id="dis-chart-4"></div>
    			</div>
    		</div>
    		<div class="col-sm-12 col-lg-2 col-md-2">
    			<div class="chart-box">
    				<div class="" id="dis-chart-5f"></div>
    				<div class="" id="dis-chart-5"></div>
    			</div>
    		</div>
    		<div class="col-sm-12 col-lg-2 col-md-2">
    			<div class="chart-box">
    				<div class="" id="dis-chart-6f"></div>
    				<div class="" id="dis-chart-6"></div>
    			</div>
    		</div>
    	</div>
    </div>

    <script>
    	$(document).ready(function(){


    		 $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_main_chart.php'; ?>",
		      data:{cahart_status:1},
		      success:function(f_resp_main)
		      {
		       
		          $("#dis-main-chart-1").html(f_resp_main);
		          $("#dis-main-chart-1f").css({"display":"none"});
		          $("#dis-main-chart-1").css({"display":"block"});
		      }
		    });


        
    setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_main_chart.php'; ?>",
		      datatype:"html",
		      success:function(resp_main_chart)
		      {
		          //$("#dis-main-chart-").html(resp_main_chart);
		          $("#dis-main-chart-1").html(resp_main_chart);
		          $("#dis-main-chart-1").css({"display":"block"});
		      }
		    });
		}, 1800000);//time in milliseconds 






     
      $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_1.php'; ?>",
		      data:{cahart_status:1},
		      success:function(f_resp1)
		      {
		          $("#dis-chart-1").html(f_resp1);
		          $("#dis-chart-1f").css({"display":"none"});
		      }
		    });

      $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_2.php'; ?>",
		      data:{cahart_status:1},
		      success:function(f_resp2)
		      {
		          $("#dis-chart-2").html(f_resp2);
		          $("#dis-chart-2f").css({"display":"none"});
		      }
		    });

      $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_3.php'; ?>",
		      data:{cahart_status:1},
		      success:function(f_resp3)
		      {
		          $("#dis-chart-3").html(f_resp3);
		          $("#dis-chart-3f").css({"display":"none"});
		      }
		    });

      $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_4.php'; ?>",
		      data:{cahart_status:1},
		      success:function(f_resp4)
		      {
		          $("#dis-chart-4").html(f_resp4);
		          $("#dis-chart-4f").css({"display":"none"});
		      }
		    });

      $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_5.php'; ?>",
		      data:{cahart_status:1},
		      success:function(f_resp5)
		      {
		          $("#dis-chart-5").html(f_resp5);
		          $("#dis-chart-5f").css({"display":"none"});
		      }
		    });
 
 $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_6.php'; ?>",
		      data:{cahart_status:1},
		      success:function(f_resp6)
		      {
		          $("#dis-chart-6").html(f_resp6);
		          $("#dis-chart-6f").css({"display":"none"});
		      }
		    });

   
 
 
		setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_1.php'; ?>",
		      datatype:"html",
		      success:function(resp1)
		      {
		          $("#dis-chart-1").html(resp1);
		          $("#dis-chart-1f").css({"display":"none"});
		      }
		    });
		}, 1800000);//time in milliseconds 


		setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_2.php'; ?>",
		      datatype:"html",
		      success:function(resp2)
		      {
		          $("#dis-chart-2").html(resp2);
		      }
		    });
		}, 1800000);//time in milliseconds 

		setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_3.php'; ?>",
		      datatype:"html",
		      success:function(resp3)
		      {
		          $("#dis-chart-3").html(resp3);
		      }
		    });
		},1800000);//time in milliseconds 

		setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_4.php'; ?>",
		      datatype:"html",
		      success:function(resp4)
		      {
		          $("#dis-chart-4").html(resp4);
		      }
		    });
		}, 1800000);//time in milliseconds 


		setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_5.php'; ?>",
		      datatype:"html",
		      success:function(resp5)
		      {
		          $("#dis-chart-5").html(resp5);
		      }
		    });
		}, 1800000);//time in milliseconds 

		setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_chart_6.php'; ?>",
		      datatype:"html",
		      success:function(resp6)
		      {
		          $("#dis-chart-6").html(resp6);
		      }
		    });
		}, 1800000);//time in milliseconds 






    	});
    </script>


<div class="container-fluid">
	<div class="row top-chart-row">
		<div class="container">
      <div class="chart-box">
    				<div class="" id="chart2"></div>
    	</div>
    	<script>
    		 	$(document).ready(function(){
           
           var symbolName = '';

    		 $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_main_chart.php'; ?>",
		      data:{cahart_status:1,symbolName:symbolName},
		      success:function(f_resp_main)
		      {  
		          $("#chart2").html(f_resp_main);
		      }
		    });
		});
    	</script>
   </div>
	</div>
</div>

<script>
	$(document).ready(function(){
     
      $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_chart.php'; ?>",
		      data:{cahart_status:1},
		      success:function(respnft)
		      {
		          $("#nfty-chart-1").html(respnft);
		          $("#nfty-chart-1f").css({"display":"none"});
		      }
		    });

      setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_chart.php'; ?>",
		      datatype:"html",
		      success:function(respnft2)
		      {
		          $("#nfty-chart-1").html(respnft2);
		      }
		    });
		}, 5000);//time in milliseconds 

/***
---------------------------------------------------
 GET NFITY VALUE LIVE 
---------------------------------------------------
***/

       $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_value.php'; ?>",
		      data:{cahart_status:1},
		      success:function(nifty_value0)
		      {
		          $("#nifty_value1").html(nifty_value0);
		      }
		    });

       setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_value.php'; ?>",
		      datatype:"html",
		      success:function(nifty_value)
		      {
		          $("#nifty_value").html(nifty_value);
		          $("#nifty_value1").css({"display":"none"});
		      }
		    });
		}, 1000);//time in milliseconds 


 /***
 ---------------------------------------------------
     GET SENSEX VALUE LIVE 
 ---------------------------------------------------
 ***/


        $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_sensex_value.php'; ?>",
		      data:{cahart_status:1},
		      success:function(sensex_value0)
		      {
		          $("#sensex_value1").html(sensex_value0);
		      }
		    });

       setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_sensex_value.php'; ?>",
		      datatype:"html",
		      success:function(sensex_value)
		      {
		          $("#sensex_value").html(sensex_value);
		          $("#sensex_value1").css({"display":"none"});
		      }
		    });
		}, 1000);//time in milliseconds 



 /***
 ---------------------------------------------------
     GET  BANK NIFTY VALUE LIVE 
 ---------------------------------------------------
 ***/


        $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_bank_nifty_value.php'; ?>",
		      data:{cahart_status:1},
		      success:function(banknifty_value0)
		      {
		          $("#banknifty_value1").html(banknifty_value0);
		      }
		    });

       setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_bank_nifty_value.php'; ?>",
		      datatype:"html",
		      success:function(banknifty_value)
		      {
		          $("#banknifty_value").html(banknifty_value);
		          $("#banknifty_value1").css({"display":"none"});
		      }
		    });
		}, 1000);//time in milliseconds 


/***
---------------------------------------------------
        GET NIFTY 100 VALUE LIVE 
---------------------------------------------------
***/

        $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty100_value.php'; ?>",
		      data:{cahart_status:1},
		      success:function(nifty100_value0)
		      {
		          $("#nifty100_value1").html(nifty100_value0);
		      }
		    });

       setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty100_value.php'; ?>",
		      datatype:"html",
		      success:function(nifty100_value)
		      {
		          $("#nifty100_value").html(nifty100_value);
		          $("#nifty100_value1").css({"display":"none"});
		      }
		    });
		}, 1000);//time in milliseconds 

/***
---------------------------------------------------
        GET NIFTY IT VALUE LIVE 
---------------------------------------------------
***/

        $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_it_value.php'; ?>",
		      data:{cahart_status:1},
		      success:function(niftyIT_value0)
		      {
		          $("#niftyIT_value1").html(niftyIT_value0);
		      }
		    });

       setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_it_value.php'; ?>",
		      datatype:"html",
		      success:function(niftyIT_value)
		      {
		          $("#niftyIT_value").html(niftyIT_value);
		          $("#niftyIT_value1").css({"display":"none"});
		      }
		    });
		}, 1000);//time in milliseconds 


/***
---------------------------------------------------
        GET NIFTY PHARMA VALUE LIVE 
---------------------------------------------------
***/

        $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_pharma_value.php'; ?>",
		      data:{cahart_status:1},
		      success:function(niftyPharma_value0)
		      {
		          $("#niftyPharma_value1").html(niftyPharma_value0);
		      }
		    });

       setInterval(function()
		{ 
		    $.ajax({
		      type:"post",
		      url:"<?php echo STX_FULL_PLUGIN_URL.'admin/template/ajax/display_nifty_pharma_value.php'; ?>",
		      datatype:"html",
		      success:function(niftyPharma_value)
		      {
		          $("#niftyPharma_value").html(niftyPharma_value);
		          $("#niftyPharma_value1").css({"display":"none"});
		      }
		    });
		}, 1000);//time in milliseconds 


     
});
</script>

<?php } ?>
	
</body>
</html>






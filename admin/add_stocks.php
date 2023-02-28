<?php include('header.php'); 

 global $wpdb,$table_prefix;
 $wp_stock_overview = $table_prefix.'stock_overview';


if(isset($_POST["submit"])){
		
     if($_FILES['file']['name'] == ""){
     	$msg_2 = "Please Select a file";
     }else{

		 $filename=$_FILES["file"]["tmp_name"];
		 if($_FILES["file"]["size"] > 0)
		 {

		  	$file = fopen($filename, "r");
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {           
		         $data =	array( 
	             'symbol' =>@$emapData[0] ,
	             'content' =>@$emapData[1] ,
	             'name' => @$emapData[2],
	             'country' => @$emapData[4] ,
	             'ipo_year' =>@$emapData[5] ,
	             'sector' => @$emapData[6] ,
	             'industry' => @$emapData[7],
	             'status' => 1,
		         	);

	            $res = $wpdb->insert($wp_stock_overview, $data);
		         	 
	 
							if(! $res == true )
							{
								echo "<script>
										alert('Invalid File:Please Upload CSV File.');
										document.location.href = '".STX_ADMIN_URL."admin.php?page=add_stocks'
									</script>";
							}

	     			}

	         fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	        
	        echo "<script>
						alert('CSV File has been successfully Imported.');
						document.location.href = '".STX_ADMIN_URL."admin.php?page=manage_stocks'
						</script>";      		 	
		  }
		}
	}	


	/* ##################  Satart 22nd Form ############### */


   if(isset($_POST['submit_2'])){

   	 $name      = $_POST['name'];
   	 $symbol    = $_POST['symbol'];
   	 $content   = $_POST['content'];
   	 $test_area = $_POST['test_area'];
   	 $country   = $_POST['country'];
   	 $ipo_year  = $_POST['ipo_year'];
   	 $sector    = $_POST['sector'];
   	 $industry  = $_POST['industry'];



     if(($name == "")||($symbol == "")||($content == "")||($ipo_year == "")||($sector == "")||($industry == "")){
     	$msg = "All Fields Required.";
     }else{
     	
       $data = array(
   	 	'name' => $name ,
   	 	'symbol' => $symbol,
   	 	'content' =>  $content,
   	 	'country' =>  $country,
   	 	'test_area' =>  $test_area,
   	 	'ipo_year' => $ipo_year,
   	 	'sector' => $sector ,
   	 	'industry' => $industry,
   	 	'status' => 2
   	 );
         
      $query = $wpdb->prepare( "SELECT * FROM wp_stock_overview WHERE symbol ='".$symbol."' " );
      $row   = $wpdb->get_row($query);
    @$fetch_symbol = $row->symbol;

      if($fetch_symbol == NULL){
        $fetch_symbol == '';
      }
     
      if($symbol == $fetch_symbol){
      	echo '<meta http-equiv="refresh" content="3">';
      	$warn_msg = "Data Already Insterted.";
      }else{

	     if($wpdb->insert($wp_stock_overview, $data)){
	     	echo '<meta http-equiv="refresh" content="3">';
	     	$success_msg = "Data Inserted Successfully.";
	     }else{
	        $err_msg = "Data Not Inserted.";  
	     }

      }

     }

   }



?>

<div class="container-fluid p-5 add_stock_form">
	<div class="row">
		<h5 class="text-primary ">Add Stocks</h5><hr class="mb-4">

		<div class="col-lg-4 col-md-4 col-sm-12">
			<h5>Import Through File</h5>
			<form action="" method="post" enctype="multipart/form-data" class="rounded shadow-sm p-4">
				 <?php if(isset($msg_2)){?><span class=" text-danger"><?php echo $msg_2; ?></span><?php } ?>
				<div class="row  mt-3">
					<div class="col-12">
						<label for="">Upload File </label> 
						<div class="input-group">
						<span class="input-group-text"><i class="fa-solid fa-file-arrow-up"></i></span>
						<input type="file" class="form-control shadow-none" name="file" id="file" >
					</div>
					</div>					
				</div>
				<div class="row mt-3">
					<div class="col-12">
						<input type="submit" id="submit" name="submit" class="btn btn-success" value="Submit">
					</div>					
				</div>
			</form>
		</div>




		<div class="col-lg-8 col-md-8 col-sm-12  ">
		<div class="container d-flex justify-content-between align-items-center">
			<h5>Add Manual</h5>
			 <?php if(isset($msg)){?><h6 class="custom-alert-danger" role="alert"><?php echo $msg; ?></h6><?php } ?>
			 <?php if(isset($err_msg)){?><h6 class="custom-alert-danger" role="alert"><?php echo $err_msg; ?></h6><?php } ?>
			 <?php if(isset($warn_msg)){?><h6 class="custom-alert-warning" role="alert"><?php echo $warn_msg; ?></h6><?php } ?>
			 <?php if(isset($success_msg)){?><h6 class="custom-alert-success" role="alert"><?php echo $success_msg; ?></h6><?php } ?>
		</div>
            <form action="" method="post" enctype="multipart/form-data" class="rounded shadow-sm p-5 ">
				<div class="row  mt-3">
					<div class="col-6">
						<label for="">Name</label>
						<div class="input-group">
						 <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
						 <input type="text" class="form-control border" name="name">
						</div>
					</div>
					<div class="col-6">
						<label for="">Symbol</label>
						<div class="input-group">
						<span class="input-group-text"> <i class="fa-solid fa-arrows-spin"></i></span>
						<input type="text" class="form-control border" name="symbol">
					</div>
					</div>					
				</div>

				<div class="row  mt-3">
					<div class="col-6">
						<label for="">Content</label>
						<div class="input-group">
						<span class="input-group-text"> <i class="fa-solid fa-file"></i></span>
						<input type="text" class="form-control border" name="content">
					</div>
					</div>
					<div class="col-6">
						<label for="">Test Area </label>
						<div class="input-group">
						<span class="input-group-text"><i class="fa-regular fa-file-lines"></i></span>
						<input type="text" class="form-control border" name="test_area">
					</div>
					</div>					
				</div>

				<div class="row  mt-3">
					<div class="col-6">
						<label for="">Country</label>
						<div class="input-group">
						<span class="input-group-text"><i class="fa-regular fa-flag"></i></span>
						<input type="text" class="form-control border" name="country">
					</div>
					</div>
					<div class="col-6">
						<label for="">IPO Year</label>
						<div class="input-group">
						<span class="input-group-text"><i class="fa-solid fa-atom"></i></span>
						<input type="text" class="form-control border" name="ipo_year">
					</div>
					</div>					
				</div>

				<div class="row  mt-3">
					<div class="col-6">
						<label for="">Sector</label>
						<div class="input-group">
						<span class="input-group-text"> <i class="fa-solid fa-vector-square"></i></span>
						<input type="text" class="form-control border" name="sector">
					</div>
					</div>
					<div class="col-6">
						<label for="">Industry</label>
						<div class="input-group">
						<span class="input-group-text"> <i class="fa-solid fa-industry"></i></span>
						<input type="text" class="form-control border" name="industry">
					  </div>
					</div>					
				</div>


				<div class="row mt-3">
					<div class="col-1 mt-2 ml-3 ">
						<input type="submit" name="submit_2" class="btn btn-success" value="Submit">
					</div>
					<div class="col-1 mt-2 mx-4">
						<button type="reset" class="btn btn-danger shadow-none">Reset</button>
					</div>				
				</div>
			</form>

		</div>

	</div>
</div>

<?php include('footer.php'); ?>
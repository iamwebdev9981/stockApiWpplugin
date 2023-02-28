<?php include('header.php');
	global $wpdb,$table_prefix;
	$wp_stock_overview = $table_prefix.'stock_overview';

	if(@$_GET['id']){
   
 $id = $_GET['id'];
 $page_no = @$_GET['pageno'];
 $delete = @$_GET['action'];

 if($delete == ""){

 $res = $wpdb->get_row("SELECT * FROM $wp_stock_overview WHERE id='".$id."' ");


					if(isset($_POST['update'])){

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
		 	 	'status' => 3
		 	  );

	   	    $query =  $wpdb->update($wp_stock_overview, $data ,array('id'=>$id));
      
      
        if($query == true){
      
          	$success_msg = "Data Updated Successfully.";
           //echo '<meta http-equiv="refresh" content="3">';

           echo'<script>

					       function redirect () {
					        var interval = setInterval(myURL, 3000);
					        var result = document.getElementById("result");
					        result.innerHTML = "<b> The page will redirect after delay of 5 seconds setInterval() method.";
					      }

				      function myURL() {
				         document.location.href = "'.STX_ADMIN_URL.'admin.php?page=manage_stocks&pageno='.$page_no.'";
				         clearInterval(interval);
				      }
      							redirect();
          </script>';   
        }else{
  
          	$warn_msg = "Data Updating Failed.";
           echo '<meta http-equiv="refresh" content="3">';

        }

				}

			}
			
?>
    												<!-- Start form  -->
    						<div class="container p-4 mt-5 border">

							  <div class="container d-flex justify-content-between align-items-center">
										<h5>Update Stock</h5>
										 <?php if(isset($msg)){?><h6 class="custom-alert-danger" role="alert"><?php echo $msg; ?></h6><?php } ?>
							 <?php if(isset($err_msg)){?><h6 class="custom-alert-danger" role="alert"><?php echo $err_msg; ?></h6><?php } ?>
										 <?php if(isset($warn_msg)){?><h6 class="custom-alert-warning" role="alert"><?php echo $warn_msg; ?></h6><?php } ?>
										 <?php if(isset($success_msg)){?><h6 class="custom-alert-success" role="alert"><?php echo $success_msg; ?></h6><?php } ?>
									</div><hr class="border">
           

												<form action="" method="post" enctype="multipart/form-data" class=" p-3 ">

													<div class="row ">
														<div class="col-6">
															<div class="input-group">
															<span class="input-group-text">Name</span>
															<input type="text" class="form-control border " name="name" value="<?php echo $res->name ?>">
															</div>
														</div>
														<div class="col-6">
															<div class="input-group">
															<span class="input-group-text">Symbol</span>
															<input type="text" class="form-control border" name="symbol" value="<?php echo $res->symbol ?>">
														</div>
													</div>
													</div>

													<div class="row  mt-4">
														<div class="col-12">
															<div class="input-group">
															<span class="input-group-text">Content</span>
															<input type="text" class="form-control border " name="content" value="<?php echo $res->content ?>" >
															</div>
														</div>
													</div>

													<div class="row  mt-4">
														<div class="col-6">
															<div class="input-group">
															<span class="input-group-text">Country</span>
															<input type="text" class="form-control border" name="country" value="<?php echo $res->country ?>">
														</div>
													</div>
													<div class="col-6">
															<div class="input-group">
															<span class="input-group-text">IPO Year</span>
															<input type="text" class="form-control border" name="ipo_year" value="<?php echo $res->ipo_year ?>">
														</div>
													</div>
													</div>


													<div class="row  mt-4">
														<div class="col-6">
															<div class="input-group">
															<span class="input-group-text">Sector</span>
															<input type="text" class="form-control border" name="sector" value="<?php echo $res->sector ?>">
														</div>
													</div>
													<div class="col-6">
															<div class="input-group">
															<span class="input-group-text">Test Area</span>
															<input type="text" class="form-control border " name="test_area" value="<?php echo $res->test_area ?>">
															</div>
														</div>
													</div>

													<div class="row mt-4">
														<div class="col-12">
															<div class="input-group">
															<span class="input-group-text">Industry</span>
															<input type="text" class="form-control border " name="industry" value="<?php echo $res->industry ?>" >
															</div>
														</div>
													</div>

													<div class="row mt-4">
														<div class="col-3">
															<input type="submit" name="update" class="btn btn-success" value="Update">
														</div>
													</div>
												</form>
											</div>
		

<?php	

/*  Start code for delete record */
}else{
 	

 $del_query =  $wpdb->delete( $wp_stock_overview, array( 'id' => $id ) );

 if($del_query == true){
    echo'<script>window.location.href = "'.STX_ADMIN_URL.'admin.php?page=manage_stocks&pageno='.$page_no.'"</script>';
 }else{
 		$msg = "Data Deletion Failed.";
   //echo '<meta http-equiv="refresh" content="3">';
 }

 ?>
  <div class="container p-5 border border-danger rounded my-5 text-center">
			 <?php if(isset($msg)){?><h6 class=" display-4 text-danger"><?php echo $msg; ?></h6><?php } ?>
			 <a href="<?php echo STX_ADMIN_URL.'admin.php?page=manage_stocks&pageno='.$page_no ?>" class="text-center text-success ">Go Back</a>
		</div>

<?php
/* End delete code */
 }



}else{

    if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $total_pages_sql = $wpdb->get_var('SELECT COUNT(*) FROM wp_stock_overview ');
        
        $total_pages = ceil($total_pages_sql / $no_of_records_per_page);

        $results = $wpdb->get_results("SELECT * FROM wp_stock_overview LIMIT $offset, $no_of_records_per_page");

        /*--- code for truncate table  ---*/
        if(isset($_POST['tble_trancate'])){

        	  $tbl_tr = "TRUNCATE $wp_stock_overview";
              $wpdb->query($tbl_tr);

		 if($tbl_tr == true){
		 	   $msg = "Records deleting...";
		 	    echo '<meta http-equiv="refresh" content="3">';
		   // echo'<script>window.location.href = "'.STX_ADMIN_URL.'admin.php?page=manage_stocks&pageno='.$page_no.'"</script>';
		 }else{
		 		$msg = "Data Deletion Failed.";
		        echo '<meta http-equiv="refresh" content="3">';
		 }

		}
          
       if(!$results == ""){
 ?>
 


<div class="container mt-5 manage_stock_section ">
	<div class="row">
		<div class="d-flex justify-content-between align-items-center ">
		  <h5 class="text-primary ">Manage Stocks</h5><?php if(isset($msg)){?><span class=" text-danger"><?php echo $msg; ?></span><?php } ?>
		  <form action="" method="post">
		  	<input type="submit" name="tble_trancate" id="tble_trancate" class="btn-sm  btn-danger"  onclick="return confirm('Are you sure? Do you want to delete All Record?')" value="Delete All">
		  </form>
		</div><hr class="mt-3 mb-2">
        <div class="table-responsive">
<table class="table table-hover shadow-sm ">
	<thead class="thead">
		<tr >
			<th>Sr. No</th>
			<th>Name</th>
			<th>Symbol</th>
			<th>Content</th>
			<th>Country</th>
			<th>IPO Year</th>
			<th>Sector</th>
			<th>Industry</th>
			<th>Status</th>
			<th>Date</th>
			<th colspan="3" class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="tbody">
		<?php
		$i =1;
		foreach($results as $value){
		?>
		<tr>
			<td><?php echo $i+$offset;?></td>
			<td><p class="name_td"><?php echo $value->name;?></p></td>
			<td><?php echo $value->symbol;?></td>
			<td><?php echo $value->content;?></td>
			<td><?php echo $value->country;?></td>
			<td><?php echo $value->ipo_year;?></td>
			<td><?php echo $value->sector;?></td>
			<td><p class="name_td"><?php echo $value->industry;?></p></td>
			<td><?php
				if($value->status == 1){
				echo '<span class="badge bg-dark">By File</span>';
				}elseif($value->status == 2){
				echo '<span class="badge bg-primary">Added Manual</span>';
				}elseif($value->status == 3){
     echo '<span class="badge bg-primary">Updated</span>';
				}
				?>
			</td>
			<td><?php echo date('d-m-Y',strtotime($value->add_on)); ?></td>
			<td>

				<a class="" data-bs-toggle="modal" data-bs-target="<?php echo '#myModal_'.$i+$offset; ?>">
					<i class="fa-solid fa-eye text-success"></i>
				</a>
					<!-- The Modal -->
					<div class="modal" id="<?php echo 'myModal_'.$i+$offset; ?>">
						<div class="modal-dialog modal-lg modal-dialog-centered">
							<div class="modal-content">
								<!-- Modal Header -->
								<div class="modal-header">
									<h4 class="modal-title">ID <?php echo $value->id;?></h4>
									<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
								</div>
								<!-- Modal body -->
								<div class="modal-body">
        <?php
          $m_id =  $value->id;
									 $res_model = $wpdb->get_row("SELECT * FROM $wp_stock_overview WHERE id='".$m_id."' ");

									 //echo 'myModal_'.$i+$offset; ?>
             
          <div class="container-fluid p-3 border rounded border-light shadow-sm">
           <div class="row mt-3">
											 <div class="col-2"><p><strong>Name</strong></p></div><div class="col-10"><p><?php echo $res_model->name;?></p></div>
											</div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>Symbol</strong></p></div><div class="col-10"><p><?php echo $res_model->symbol;?></p></div>
											 </div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>Content</strong></p></div><div class="col-10"><p><?php echo $res_model->content;?></p></div>
											 </div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>Country</strong></p></div><div class="col-10"><p><?php echo $res_model->country;?></p></div>
											 </div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>IPO Year</strong></p></div><div class="col-10"><p><?php echo $res_model->ipo_year;?></p></div>
											 </div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>Sector</strong></p></div><div class="col-10"><p><?php echo $res_model->sector;?></p></div>
											 </div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>Industry</strong></p></div><div class="col-10"><p><?php echo $res_model->industry;?></p></div>
											 </div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>Status</strong></p></div><div class="col-10"><p><?php
																											if($res_model->status == 1){
																											echo '<span class="badge bg-dark">By File</span>';
																											}elseif($res_model->status == 2){
																											echo '<span class="badge bg-primary">Added Manual</span>';
																											}elseif($res_model->status == 3){
																							     echo '<span class="badge bg-primary">Updated</span>';
																											}
																											?></p></div>
																											</div>
											<div class="row mt-3">
											 <div class="col-2"><p><strong>Date</strong></p></div><div class="col-10"><p><?php echo date('d-m-Y',strtotime($res_model->add_on)); ?></p></div>
										 </div>

        </div>
								</div>	<!-- End model body -->
							</div>
						</div>
					</div>

					</td>
					<td>
						<a href="<?php echo STX_ADMIN_URL?>admin.php?page=manage_stocks&id=<?php echo $value->id; ?>&pageno=<?php echo $pageno; ?> ">
							<i class="fa-regular fa-pen-to-square text-primary"></i>
						</a>
					</td>
					<td>
						<a href="<?php echo STX_ADMIN_URL?>admin.php?page=manage_stocks&id=<?php echo $value->id; ?>&pageno=<?php echo $pageno; ?>&action=delete " class=""  onclick="return confirm('Are you sure? Do you want to delete this Record?')">
							<i class="fa-solid fa-trash-can-arrow-up text-danger"></i>
						</a>
					</td>
				</tr>
			</div>
			

			<?php $i++; } ?>
		</tbody>
		
	</table>
      </div>
      <ul class="pagination ">
		        <li><a href="admin.php?page=manage_stocks&pageno=1" class="btn-sm btn-primary m-1">First</a></li>
		        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
		            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "admin.php?page=manage_stocks&pageno=".($pageno - 1); } ?>"  class="btn-sm btn-primary m-1"><i class="fa-solid fa-chevron-left"></i> Prev</a>
		        </li>
		        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
		            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "admin.php?page=manage_stocks&pageno=".($pageno + 1); } ?>" class="btn-sm btn-primary m-1">Next <i class="fa-solid fa-angle-right"></i></a>
		        </li>
		        <li><a href="admin.php?page=manage_stocks&pageno=<?php echo $total_pages; ?>" class="btn-sm btn-primary m-1">Last</a></li>
		    </ul>
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
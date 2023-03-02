<?php 
require_once('../../../../../../wp-config.php');


  global $wpdb,$table_prefix;
  $wp_stock_overview = $table_prefix.'stock_overview';

  if (isset($_POST["search"])) {
    $searchTerm = $_POST["search"];

     if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 132;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $total_pages_sql = $wpdb->get_var('SELECT COUNT(*) FROM wp_stock_overview ');
        
        $total_pages = ceil($total_pages_sql / $no_of_records_per_page);

       // $results = $wpdb->get_results("SELECT * FROM wp_stock_overview LIMIT $offset, $no_of_records_per_page");

$sql = "SELECT * FROM $wp_stock_overview WHERE CONCAT(`id`, `symbol`) LIKE '%".$searchTerm."%' LIMIT ".$offset.", ".$no_of_records_per_page.";";
    //$array = array("apple", "banana", "cherry", "date", "elderberry");
$result = $wpdb->get_results($sql);?>


<?php if($result){?>


  <div class="container-fluid search_container_overlay ">
    <div class="container">
    <div class="d-flex justify-content-between">
      <div class=""></div>
      <button id="close_btn" class="close_btn"><i class="fa-solid fa-xmark"></i></button>
    </div>
    
    <div class="row">
       <?php  foreach($result as $value){ ?>
     <div class="col-sm-1 col-lg-1 col-md-2 p-0">
      <div class="symbol-box border border-info">
         <a  class="title" href="<?php echo STX_ADMIN_URL?>admin.php?page=dashboard&id=<?php echo $value->id; ?>&pageno=<?php echo $pageno; ?> "><?php echo $value->symbol;?></a>
      </div>
     </div>
    <?php } ?>
    </div>
  


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

<?php }else{
  echo "No Data Found.";
}
}

?>

<script>
  $(document).ready(function(){
   $('#close_btn').click(function(){
    $('.search_container_overlay').fadeOut(1000);
   })
  });
</script>

<?php
include('footer.php');
 ?>

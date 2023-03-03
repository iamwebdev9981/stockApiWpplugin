<?php 
require_once('../../../../../../wp-config.php');
require_once('../../functions.php');

$symbol = "^BSESN"; // Nifty symbol
$url = "https://query1.finance.yahoo.com/v7/finance/chart/$symbol?range=1d&interval=1m"; 
//$url = "https://query1.finance.yahoo.com/v7/finance/chart/$symbol?range=1d&interval=1m";// API URL

if($_POST['cahart_status']){
	$chart_status = $_POST['cahart_status'];
}

if($chart_status == 1){
	echo __getLiveSensex($url,$symbol);
}else{
	echo __getLiveSensex($url,$symbol);
}

 ?>
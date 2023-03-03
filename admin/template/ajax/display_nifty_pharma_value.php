<?php 
require_once('../../../../../../wp-config.php');
require_once('../../functions.php');

$symbol = "^CNXPHARMA"; // The symbol for Nifty Pharma index
$url = "https://query1.finance.yahoo.com/v7/finance/chart/$symbol?range=1d&interval=1m";

if($_POST['cahart_status']){
	$chart_status = $_POST['cahart_status'];
}

if($chart_status == 1){
	echo __getNiftyPharma($url,$symbol);
}else{
	echo __getNiftyPharma($url,$symbol);
}

 ?>
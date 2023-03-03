<?php 
require_once('../../../../../../wp-config.php');
require_once('../../functions.php');

$res = __getRowData('stock_overview','2');

$url = $res->content;
$symbol = $res->symbol;
$name = $res->name;
$chartType = 'area';

if($_POST['cahart_status']){
	$chart_status = $_POST['cahart_status'];
}

if($chart_status == 1){
	echo __showChart($url,$symbol,$name,$chartType,001);
}else{
	echo __showChart($url,$symbol,$name,$chartType,1);
}


 ?>
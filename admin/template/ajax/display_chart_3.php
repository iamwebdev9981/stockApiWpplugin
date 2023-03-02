<?php 
require_once('../../../../../../wp-config.php');
require_once('../../functions.php');

$url = 'https://query1.finance.yahoo.com/v8/finance/chart/ABCL?metrics=high?&interval=1d&range=24mo';
$symbol = 'ABCL';
$chartType = 'area';

if($_POST['cahart_status']){
    $chart_status = $_POST['cahart_status'];
}

if($chart_status == 1){
    echo __showChart($url,$symbol,$chartType,003);
}else{
    echo __showChart($url,$symbol,$chartType,3);
}


 ?>
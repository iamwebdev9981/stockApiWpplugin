<?php 
require_once('../../../../../../wp-config.php');
require_once('../../functions.php');



$url = 'https://query1.finance.yahoo.com/v8/finance/chart/AAPL?metrics=high?&interval=1d&range=24mo';
$symbol = 'AAPL';
$name = 'Apple Inc. Common Stock';
$chartType = 'candlestick';

if(isset($_POST['chart_name'])){
    $chartT = $_POST['chart_name']; 
   echo __showChart($url,$symbol,$name,$chartT,3333);
}else{
    if($_POST['cahart_status']){
        $chart_status = $_POST['cahart_status'];
    }

    if($chart_status == 1){
        echo __showChart($url,$symbol,$name,$chartType,111);
    }else{
        echo __showChart($url,$symbol,$name,$chartType,112);
    }
}


if (isset($_POST['symbolName'])){
    $url = 'https://query1.finance.yahoo.com/v8/finance/chart/AAPL?metrics=high?&interval=1d&range=24mo';
    $symbol = 'AMZN';
    $name = 'Amazon.com, Inc. Common Stock';
    $chartType = 'line';

     echo __showChart($url,$symbol,$name,$chartType,3333);
}

 ?>
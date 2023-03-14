<?php 
require_once('../../../../../../wp-config.php');
require_once('../../functions.php');



$url = 'https://query1.finance.yahoo.com/v8/finance/chart/AAPL?metrics=high?&interval=1d&range=24mo';
$symbol = 'AAPL';
$name = 'Apple Inc. Common Stock';
$chartType = 'candlestick';

if(isset($_POST['chart_name'])){

    if(isset($_POST['symbol_name'])){

    $symbol_name = $_POST['symbol_name'];
    $chartT = $_POST['chart_name'];

    $url = 'https://query1.finance.yahoo.com/v8/finance/chart/'.$symbol_name.'?metrics=high?&interval=1d&range=24mo';
    $name = 'Amazon.com, Inc. Common Stock';


   __showChart($url,$symbol_name,$name,$chartT,33333);
}else{
      $chartT = $_POST['chart_name']; 
   __showChart($url,$symbol,$name,$chartT,3333);
}


}else{
    if($_POST['cahart_status']){
        $chart_status = $_POST['cahart_status'];
    }

    if($chart_status == 1){
         __showChart($url,$symbol,$name,$chartType,111);
    }else{
         __showChart($url,$symbol,$name,$chartType,112);
    }
}


if (isset($_POST['symbolName'])){
    $url = 'https://query1.finance.yahoo.com/v8/finance/chart/AMZN?metrics=high?&interval=1d&range=24mo';
    $symbol = 'AMZN';
    $name = 'Amazon.com, Inc. Common Stock';
    $chartType = 'area';
      __showChart($url,$symbol,$name,$chartType,3333);
}



 ?>
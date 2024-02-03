<?php
error_reporting(0);
$id = isset($_GET['id'])?$_GET['id']:'11342412';//房间号


$bstrURL = 'https://www.huya.com/'.$id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $bstrURL);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_ENCODING, '');
$data = curl_exec($ch);
curl_close($ch);

if (preg_match('/"sStreamName":"([^"]+)".*?"sHlsUrl":"([^"]+)".*?"sHlsUrlSuffix":"([^"]+)".*?"sHlsAntiCode":"([^"]+)"/s', $data, $matches)) {

       
    $sStreamName = $matches[1];
    $sHlsUrl = $matches[2];
    $sHlsUrlSuffix = $matches[3];
    $sHlsAntiCode = $matches[4];
    $url = $sHlsUrl.'/'.$sStreamName.'.'.$sHlsUrlSuffix.'?'.$sHlsAntiCode;
    $url = explode("&fm", $url)[0];
    $url = preg_replace("|ratio=2000&|", "",$url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "http://www.huya.com/");
    $data = curl_exec($ch);
    curl_close($ch);
    $burl = dirname($url). "/";
    print_r(preg_replace("/(.*?.ts)/i", $burl . "$1",$data));
}

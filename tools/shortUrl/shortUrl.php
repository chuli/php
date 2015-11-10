<?php

require __DIR__ .'/../Curl.php';

define('SINA_APPKEY', '31641035');

$url = 'https://github.com/chuli/php';
$bdShortUrl = baiduShortenUrl($url);
print_r("\n");
baiduExpandUrl($bdShortUrl);
print_r("\n");
$tShortUrl = sinaShortenUrl($url);
print_r("\n");
sinaExpandUrl($tShortUrl);


function sinaShortenUrl($longUrl) {
    $url = 'http://api.t.sina.com.cn/short_url/shorten.json';
    $method = 'GET';
    $params = array('source' => SINA_APPKEY, 'url_long' => $longUrl);
    $curl = new Curl($url, $method, $params);
    $ret = $curl->execute();
    print_r($ret[0]['url_short']);
    return $ret[0]['url_short'];
}

function sinaExpandUrl($shortUrl) {
    $url = 'http://api.t.sina.com.cn/short_url/expand.json';
    $method = 'GET';
    $params = array('source' => SINA_APPKEY, 'url_short' => $shortUrl);
    $curl = new Curl($url, $method, $params);
    $ret = $curl->execute();
    print_r($ret[0]['url_long']);
    return $ret[0]['url_long'];
}

function baiduShortenUrl($longUrl) {
    $url = 'http://dwz.cn/create.php';
    $method = 'POST';
    $params = array('url' => $longUrl);
    $curl = new Curl($url, $method, $params);
    $ret = $curl->execute();
    print_r($ret['tinyurl']);
    return $ret['tinyurl'];
}

function baiduExpandUrl($shortUrl) {
    $url = 'http://dwz.cn/query.php';
    $method = 'POST';
    $params = array('tinyurl' => $shortUrl);
    $curl = new Curl($url, $method, $params);
    $ret = $curl->execute();
    print_r($ret['longurl']);
    return $ret['longurl'];
}

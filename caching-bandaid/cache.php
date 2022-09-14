<?php

if($_GET['force_clear'] ?? false) apcu_clear_cache();

header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *');

http_response_code(400);
$url = $_GET['url'] ?? die('no url provided');

http_response_code(401);
$host = parse_url($url, PHP_URL_HOST);
if(!in_array($host, ['opensheet.elk.sh', 'webapps.macalester.edu', 'macalester.edu', 'www.wmcn.fm'])) die('url is not whitelisted');

http_response_code(200);
if($data = apcu_fetch($url)) die($data);

$data = file_get_contents($url);
apcu_add($url, $data, 60*30);
echo $data;
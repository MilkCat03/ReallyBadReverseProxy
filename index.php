<?php
$targetURL = $_GET['url'] ?? '';

if (empty($targetURL)) {
    http_response_code(400);
    echo "Missing 'url' parameter";
    exit();
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $targetURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);

$info = curl_getinfo($ch);

curl_close($ch);

$headersSize = $info['header_size'];
$headers = substr($response, 0, $headersSize);
$body = substr($response, $headersSize);

$headers = preg_replace('/X-Frame-Options:.*/i', '', $headers);
echo $headers . $body;
?>
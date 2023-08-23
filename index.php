<?php
$targetURL = $_GET['url'] ?? ''; // Get the target URL from the query parameter

if (empty($targetURL)) {
    http_response_code(400);
    echo "Missing 'url' parameter";
    exit();
}

// Create a new cURL handle
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $targetURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirections
curl_setopt($ch, CURLOPT_HEADER, true);

// Execute cURL request and get the response
$response = curl_exec($ch);

if ($response === false) {
    http_response_code(500);
    echo "Failed to fetch URL: " . curl_error($ch);
    exit();
}

// Get the cURL info, including the response headers
$info = curl_getinfo($ch);

// Close cURL handle
curl_close($ch);

// Split the response into headers and body
$headersSize = $info['header_size'];
$headers = substr($response, 0, $headersSize);
$body = substr($response, $headersSize);

// Remove X-Frame-Options header from the response headers
$headers = preg_replace('/X-Frame-Options:.*/i', '', $headers);

// Output the modified headers and body
echo $headers . $body;
?>

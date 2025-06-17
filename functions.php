<?php
session_start();

function callMyfxbookAPI($endpoint, $params = []) {
    $url = "https://www.myfxbook.com/api/{$endpoint}.json?" . http_build_query($params);
    $context = stream_context_create(['http' => ['timeout' => 10]]);
    $response = file_get_contents($url, false, $context);
    return json_decode($response, true);
}

function requireLogin() {
    if (empty($_SESSION['session'])) {
        header('Location: index.php');
        exit;
    }
}
?>

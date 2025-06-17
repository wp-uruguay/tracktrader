<?php
// Archivo: myfxbook-api.php

function myfxbook_login($email, $password) {
    $url = "https://www.myfxbook.com/api/login.json?email=" . urlencode($email) . "&password=" . urlencode($password);
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    return $data['session'] ?? null;
}

function myfxbook_logout($session) {
    $url = "https://www.myfxbook.com/api/logout.json?session=" . urlencode($session);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getAccounts($session) {
    $url = "https://www.myfxbook.com/api/get-my-accounts.json?session=" . urlencode($session);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getHistory($session, $accountId) {
    $url = "https://www.myfxbook.com/api/get-history.json?session=$session&id=$accountId";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getDailyGain($session, $accountId, $startDate, $endDate) {
    $url = "https://www.myfxbook.com/api/get-daily-gain.json?session=$session&id=$accountId&start=$startDate&end=$endDate";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getGain($session, $accountId) {
    $url = "https://www.myfxbook.com/api/get-gain.json?session=$session&id=$accountId";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getOpenTrades($session, $accountId) {
    $url = "https://www.myfxbook.com/api/get-open-trades.json?session=$session&id=$accountId";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getOpenOrders($session, $accountId) {
    $url = "https://www.myfxbook.com/api/get-open-orders.json?session=$session&id=$accountId";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getDataDaily($session, $accountId) {
    $url = "https://www.myfxbook.com/api/get-data-daily.json?session=$session&id=$accountId";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getCommunitySentiment() {
    $url = "https://www.myfxbook.com/api/get-community-outlook.json";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function myfxbook_getCommunitySentimentByCountry() {
    $url = "https://www.myfxbook.com/api/get-community-outlook-by-country.json";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

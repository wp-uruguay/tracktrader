<?php
session_start();

if (!isset($_SESSION['demo_accounts'])) {
    $_SESSION['demo_accounts'] = [];
}

$demoId = 999000 + count($_SESSION['demo_accounts']) + 1;

$nuevaCuenta = [
    'id' => $demoId,
    'name' => 'Demo #' . ($demoId - 999000),
    'broker' => 'NextLevel Demo',
    'accountType' => 'Demo',
    'gain' => rand(5, 30),
    'drawdown' => rand(2, 15),
    'balance' => rand(1000, 5000),
    'currency' => 'USD',
    'server' => 'trkr.wpuruguay.com'
];

$_SESSION['demo_accounts'][] = $nuevaCuenta;

// redireccion
header('Location: index.php');
exit;


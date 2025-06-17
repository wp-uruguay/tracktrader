<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    if (isset($_SESSION['demo_accounts'])) {
        $_SESSION['demo_accounts'] = array_filter($_SESSION['demo_accounts'], function($cuenta) use ($id) {
            return $cuenta['id'] != $id;
        });
        $_SESSION['demo_accounts'] = array_values($_SESSION['demo_accounts']);
    }
}

// Redirigir de nuevo a index.php
header('Location: index.php');
exit;

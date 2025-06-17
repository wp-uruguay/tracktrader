<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['myfx_email'], $_POST['myfx_password'])) {
    $email = $_POST['myfx_email'];
    $password = $_POST['myfx_password'];

    $url = 'https://www.myfxbook.com/api/login.json?email=' . urlencode($email) . '&password=' . urlencode($password);
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && isset($data['session'])) {
        $_SESSION['session'] = $data['session'];
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Error al conectar con Myfxbook. Verifica tus credenciales.";
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

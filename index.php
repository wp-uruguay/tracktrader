<?php
session_start();

// Login local simple
// Este login va a estar integrado con la base de usuario de NextLevel

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if ($email === 'nextlevel' && $pass === 'nextlevel') {
        $_SESSION['email'] = $email;
    } else {
        $error = "Credenciales incorrectas.";
    }
}

// Logout local
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Logout MFB
if (isset($_GET['logout_mfb']) && isset($_SESSION['session'])) {
    @file_get_contents('https://www.myfxbook.com/api/logout.json?session=' . urlencode($_SESSION['session']));
    unset($_SESSION['session']);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>NextLevel Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen">

<?php if (!isset($_SESSION['email'])): ?>
  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white p-6 rounded-[10px] shadow max-w-sm w-full text-center">
    <h2 class="text-xl font-bold mb-4">Iniciar sesión</h2>
    <form method="post" class="space-y-3 text-left">
      <input type="text" name="email" placeholder="Usuario" required class="w-full p-2 border rounded" />
      <input type="password" name="password" placeholder="Contraseña" required class="w-full p-2 border rounded" />
      <button class="w-full p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Entrar</button>
      <p class="mb-4"> Utiliza "nextlevel" en los dos campos </p>
    </form>
    <?php if (!empty($error)): ?>
      <p class="text-red-500 text-sm mt-2"><?php echo $error; ?></p>
    <?php endif; ?>
  </div>
  <div class="mt-4 text-center">
    <img src="https://nextlevel.wpuruguay.com/nl.png" alt="Logo NextLevel" class="h-10 mx-auto">
  </div>
</div>

</body>
</html>
<?php exit; ?>
<?php endif; ?>

<?php include 'header.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8 space-y-10">
  <!-- Perfil + Botones -->
  <div class="flex justify-between items-center flex-wrap gap-4" x-data="{ showModal: false, opened: false }">
    <div class="flex items-center gap-4">
      <div class="w-16 h-16 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl font-bold">
        <?php echo strtoupper(substr($_SESSION['email'], 0, 1)); ?>
      </div>
      <div>
        <h1 class="text-2xl font-bold">Hola, <?php echo htmlentities($_SESSION['email']); ?></h1>
        <p class="text-gray-600">Este es tu panel personalizado, puedes orfenar los widget como prefieras. </p>
      </div>
    </div>
    <div class="flex gap-2">
      <form method="post" action="agregar-cuenta-demo.php">
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 text-sm">
          + Crear cuenta demo
        </button>
      </form>
      <?php if (!isset($_SESSION['session'])): ?>
        <button @click="if (!opened) { showModal = true; opened = true; } else { window.location.href = 'conectar-cuenta.php'; }" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
          + Conectar a MFB
        </button>
      <?php else: ?>
        <a href="?logout_mfb=1" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">Desconectar MFB</a>
      <?php endif; ?>
    </div>

    <!-- Modal Myfxbook -->
    <div x-show="showModal" class="fixed inset-0 backdrop-blur-sm bg-black/10 flex items-center justify-center z-50" style="display: none;">
      <div class="bg-white p-6 rounded-[10px] shadow max-w-md w-full" @click.outside="showModal = false">
        <h2 class="text-lg font-bold mb-4">Conectar con Myfxbook</h2>
        <form method="post" action="conectar-cuenta.php" class="space-y-3">
          <input type="email" name="myfx_email" placeholder="Email de Myfxbook" required class="w-full p-2 border rounded" />
          <input type="password" name="myfx_password" placeholder="Contraseña" required class="w-full p-2 border rounded" />
          <div class="flex justify-end gap-2 pt-2">
            <button type="button" @click="showModal = false" class="text-gray-600 hover:underline">Cancelar</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Conectar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Cuentas privadas/demos -->
  <?php include 'bloque-cuentas.php'; ?>

  <!-- Card de sugerencia -->
  <div class="relative rounded-[10px] overflow-hidden shadow-lg">
  <!-- bkgr -->
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1629100551267-cae95686d737?q=80&w=1460&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Fondo corporativo" class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-white/30"></div>
  </div>

  <!-- cnt -->
  <div class="relative p-6 text-black flex flex-col justify-between min-h-[200px]">
    <div>
      <h3 class="text-2xl font-bold mb-2">¿Quieres mejorar tus habilidades de trading?</h3>
      <p class="text-sm text-gray-700 mb-4">Te ayudamos a crecer con análisis y estrategias personalizadas.</p>
      <a href="#" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">Aprender con NL</a>
    </div>
    <div class="mt-6 flex justify-end">
      <img src="https://nextlevel.wpuruguay.com/nl.png" alt="Logo NL" class="h-8">
    </div>
  </div>
</div>



  <!-- Estrategias públicas -->
  <section>
    <h3 class="text-xl font-semibold mb-4">Estrategias públicas recomendadas</h3>
    <?php include 'estrategias-publicas.php'; ?>
  </section>

  <!-- Sentimiento del mercado -->
  <section>
    <h3 class="text-xl font-semibold mb-4">Sentimiento del mercado</h3>
    <?php include 'bloque-sentimiento.php'; ?>
  </section>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

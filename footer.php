<footer class="w-full mt-10">
  <div class="max-w-7xl mx-auto px-4 py-10 text-sm text-gray-600 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Col 1: Enlaces -->
    <div>
      <h4 class="text-base font-semibold mb-2">Navegación</h4>
      <ul class="space-y-1">
        <li><a href="index.php" class="hover:underline">Inicio</a></li>
        <li><a href="#" class="hover:underline">Mis cuentas</a></li>
        <li><a href="#" class="hover:underline">Estrategias públicas</a></li>
        <li><a href="#" class="hover:underline">Sentimiento del mercado</a></li>
      </ul>
    </div>

    <!-- Col 2: Info servidor -->
    <div>
      <h4 class="text-base font-semibold mb-2">Servidor</h4>
      <p>PHP <?php echo phpversion(); ?><br>
      IP: <?php echo $_SERVER['SERVER_ADDR']; ?><br>
      Software: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
    </div>

    <!-- Col 3: Copyright -->
    <div class="text-center md:text-right">
      <p class="mb-2">© <?php echo date('Y'); ?> NEXTLEVEL · Todos los derechos reservados</p>
      <p>Desarrollado por <a href="https://muandigital.com" target="_blank" class="text-blue-600 hover:underline">MUAN Digital</a></p>
    </div>

  </div>
</footer>

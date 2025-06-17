<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<header class="w-full bg-white shadow mb-6">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
    <a href="index.php">
      <img src="https://nextlevel.wpuruguay.com/nl.png" alt="Logo" class="h-10">
    </a>
    <div class="flex items-center gap-4">
      <button id="menu-toggle" class="md:hidden text-gray-600 hover:text-black">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <a href="index.php?logout=1"
         class="flex items-center gap-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V4"/>
        </svg>
        Salir
      </a>
    </div>
  </div>
</header>

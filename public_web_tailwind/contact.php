<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | Elians Store 🧵</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .bg-gradient {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        }
    </style>
</head>

<body class="bg-white text-gray-900">

<!-- NAVBAR -->
<header class="fixed w-full bg-black text-white z-50 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        <h1 class="text-xl font-semibold tracking-wide">Elians Store</h1>
        <nav class="hidden md:flex space-x-6">
            <a href="index.html" class="hover:text-blue-400">Inicio</a>
            <a href="index.html#productos" class="hover:text-blue-400">Productos</a>
            <a href="../about.php" class="hover:text-blue-400">Nosotros</a>
            <a href="contact.php" class="text-blue-400 font-semibold">Contacto</a>
            <a href="../usuarios/login.php" class="bg-blue-600 px-4 py-2 rounded-md hover:bg-blue-700 transition">Entrar</a>
        </nav>
        <button id="menu-btn" class="md:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Menú móvil -->
    <div id="menu" class="md:hidden bg-black text-white hidden flex-col space-y-3 px-6 pb-4">
        <a href="index.html" class="hover:text-blue-400">Inicio</a>
        <a href="index.html#productos" class="hover:text-blue-400">Productos</a>
        <a href="../about.php" class="hover:text-blue-400">Nosotros</a>
        <a href="contact.php" class="text-blue-400 font-semibold">Contacto</a>
        <a href="../usuarios/login.php" class="bg-blue-600 px-4 py-2 rounded-md text-center hover:bg-blue-700 transition">Entrar</a>
    </div>
</header>

<!-- HERO -->
<section class="h-[70vh] flex flex-col justify-center items-center text-center text-white bg-gradient">
    <h1 class="text-5xl md:text-6xl font-bold fade-up">Contáctanos</h1>
    <p class="text-lg md:text-xl mt-4 max-w-xl fade-up">Queremos escucharte. Cuéntanos tus ideas, dudas o proyectos textiles.</p>
</section>

<!-- FORMULARIO DE CONTACTO -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6 bg-white rounded-2xl shadow-xl p-10 fade-up">
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-800 p-3 mb-6 rounded-md text-center">✅ Tu mensaje ha sido enviado correctamente.</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-800 p-3 mb-6 rounded-md text-center">❌ Error al enviar el mensaje. Inténtalo nuevamente.</div>
        <?php endif; ?>

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">📩 Envíanos un mensaje</h2>
        <form action="/mi_tienda_php/public_web_tailwind/procesar_contacto.php" method="POST" class="space-y-6">
            <div>
                <label class="block font-semibold mb-1">Nombre completo</label>
                <input type="text" name="nombre" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-300" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Correo electrónico</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-300" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Mensaje</label>
                <textarea name="mensaje" rows="5" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-300" required></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition">Enviar mensaje</button>
        </form>
    </div>
</section>

<!-- INFORMACIÓN DE CONTACTO -->
<section class="py-16 bg-white text-center fade-up">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">También puedes encontrarnos</h2>
    <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto px-6">
        <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold text-blue-600 mb-2">📍 Dirección</h3>
            <p class="text-gray-600">Av. Los Innovadores 456, Ica - Perú</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold text-blue-600 mb-2">📞 Teléfono</h3>
            <p class="text-gray-600">+51 999 888 777</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-xl font-semibold text-blue-600 mb-2">✉️ Correo</h3>
            <p class="text-gray-600">contacto@eliansstore.com</p>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-black text-gray-400 text-center py-6">
    © <span id="year"></span> Elians Store — Innovación textil con propósito.
</footer>

<!-- SCRIPTS -->
<script>
    // Menú móvil
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    btn.addEventListener('click', () => menu.classList.toggle('hidden'));

    // Animaciones al hacer scroll
    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.2 });
    fadeElements.forEach(el => observer.observe(el));

    // Año automático
    document.getElementById('year').textContent = new Date().getFullYear();
</script>

</body>
</html>

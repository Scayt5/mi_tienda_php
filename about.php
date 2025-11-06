<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros | Elians Store 🧵</title>
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
    </style>
</head>

<body class="bg-white text-gray-900">

<!-- NAVBAR -->
<header class="fixed w-full bg-black text-white z-50 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        <h1 class="text-xl font-semibold tracking-wide">Elians Store</h1>
        <nav class="hidden md:flex space-x-6">
            <a href="public_web_tailwind/index.html" class="hover:text-blue-400">Inicio</a>
            <a href="public_web_tailwind/index.html#productos" class="hover:text-blue-400">Productos</a>
            <a href="public_web_tailwind/contact.php" class="hover:text-blue-400">Contacto</a>
            <a href="about.php" class="text-blue-400 font-semibold">Nosotros</a>
            <a href="usuarios/login.php" class="bg-blue-600 px-4 py-2 rounded-md hover:bg-blue-700 transition">Entrar</a>
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
        <a href="public_web_tailwind/index.html" class="hover:text-blue-400">Inicio</a>
        <a href="public_web_tailwind/index.html#productos" class="hover:text-blue-400">Productos</a>
        <a href="public_web_tailwind/contact.php" class="hover:text-blue-400">Contacto</a>
        <a href="about.php" class="text-blue-400 font-semibold">Nosotros</a>
        <a href="usuarios/login.php" class="bg-blue-600 px-4 py-2 rounded-md text-center hover:bg-blue-700 transition">Entrar</a>
    </div>
</header>

<!-- HERO -->
<section class="h-[80vh] flex flex-col justify-center items-center text-center text-white bg-cover bg-center"
         style="background-image: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)), url('public_web_tailwind/assets/img/hero.jpg');">
    <h1 class="text-5xl md:text-6xl font-bold mb-4 fade-up">Sobre Nosotros</h1>
    <p class="text-lg md:text-xl max-w-2xl fade-up">Innovamos la industria textil combinando diseño, eficiencia y tecnología.</p>
</section>

<!-- CONTENIDO PRINCIPAL -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 px-6 items-center">
        <div class="fade-up">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">¿Quiénes Somos?</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                <strong>Elians Store</strong> nació con la visión de modernizar los talleres textiles mediante soluciones tecnológicas accesibles.
                Desarrollamos un sistema de gestión completo para optimizar la producción, ventas y administración de microempresas textiles.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                Nos apasiona conectar la artesanía del textil con la innovación digital. Nuestro enfoque combina software, diseño y experiencia humana
                para crear un modelo sostenible y eficiente.
            </p>
            <a href="public_web_tailwind/contact.php"
               class="inline-block mt-4 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                Contáctanos
            </a>
        </div>
        <div class="fade-up">
            <img src="public_web_tailwind/assets/img/product2.jpg" alt="Equipo de trabajo"
                 class="rounded-2xl shadow-lg w-full object-cover">
        </div>
    </div>
</section>

<!-- VALORES -->
<section class="py-16 bg-white text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 fade-up">Nuestros Valores</h2>
    <div class="grid md:grid-cols-3 gap-10 max-w-5xl mx-auto px-6">
        <div class="bg-gray-100 p-8 rounded-xl shadow hover:shadow-xl transition fade-up">
            <h3 class="text-xl font-semibold text-blue-600 mb-2">Innovación</h3>
            <p class="text-gray-600">Fusionamos moda y tecnología para impulsar el crecimiento textil del futuro.</p>
        </div>
        <div class="bg-gray-100 p-8 rounded-xl shadow hover:shadow-xl transition fade-up">
            <h3 class="text-xl font-semibold text-blue-600 mb-2">Calidad</h3>
            <p class="text-gray-600">Cada prenda, cada línea de código, busca ofrecer lo mejor a nuestros clientes.</p>
        </div>
        <div class="bg-gray-100 p-8 rounded-xl shadow hover:shadow-xl transition fade-up">
            <h3 class="text-xl font-semibold text-blue-600 mb-2">Sostenibilidad</h3>
            <p class="text-gray-600">Promovemos prácticas responsables que respeten a las personas y al planeta.</p>
        </div>
    </div>
</section>

<!-- EQUIPO -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-10 fade-up">Nuestro Equipo</h2>
        <div class="grid md:grid-cols-3 gap-10">
            <div class="fade-up">
                <img src="public_web_tailwind/assets/img/team1.jpg" class="rounded-full mx-auto w-48 h-48 object-cover shadow-lg mb-4">
                <h3 class="font-semibold text-lg">Elian Torres</h3>
                <p class="text-gray-500">Fundador & Desarrollador</p>
            </div>
            <div class="fade-up">
                <img src="public_web_tailwind/assets/img/team2.jpg" class="rounded-full mx-auto w-48 h-48 object-cover shadow-lg mb-4">
                <h3 class="font-semibold text-lg">Camila Pérez</h3>
                <p class="text-gray-500">Diseñadora Textil</p>
            </div>
            <div class="fade-up">
                <img src="public_web_tailwind/assets/img/team3.jpg" class="rounded-full mx-auto w-48 h-48 object-cover shadow-lg mb-4">
                <h3 class="font-semibold text-lg">Javier Gómez</h3>
                <p class="text-gray-500">Marketing & Estrategia</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-black text-gray-400 text-center py-6">
    © <span id="year"></span> Elians Store — Innovación textil con propósito.
</footer>

<!-- SCRIPTS -->
<script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    btn.addEventListener('click', () => menu.classList.toggle('hidden'));

    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.2 });
    fadeElements.forEach(el => observer.observe(el));


    document.getElementById('year').textContent = new Date().getFullYear();
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Praktik Magang Mahasiswa - Universitas Anda">

    <title>@yield('title', 'Sistem Praktik Magang')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .logo-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 48px;
            width: 48px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .logo-text {
            position: relative;
            margin-left: 12px;
            font-weight: 700;
            font-size: 1.25rem;
            background: linear-gradient(90deg, #ffffff, #dbeafe);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo-text::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #93c5fd);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .logo-container:hover .logo-img {
            transform: rotate(5deg) scale(1.05);
        }

        .logo-container:hover .logo-text::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .nav-link {
            position: relative;
            padding: 8px 0;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #93c5fd;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        @media (max-width: 768px) {
            .logo-text {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <header class="bg-gradient-to-r from-blue-800 to-blue-600 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="logo-container">
                    <a href="{{ route('home') }}" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white rounded">
                        <div class="flex items-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Universitas"
                                 class="logo-img rounded-full bg-white p-1 border-2 border-blue-200 shadow-md">
                            <span class="logo-text hidden sm:inline-block">Sistem Praktik Magang</span>
                        </div>
                    </a>
                </div>

                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}#about" class="nav-link hover:text-blue-200 transition-colors duration-300 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-200"></i>Tentang
                    </a>
                    <a href="{{ route('home') }}#recommendation" class="nav-link hover:text-blue-200 transition-colors duration-300 flex items-center">
                        <i class="fas fa-file-signature mr-2 text-blue-200"></i>Rekomendasi
                    </a>
                    <a href="{{ route('home') }}#praktik" class="nav-link hover:text-blue-200 transition-colors duration-300 flex items-center">
                        <i class="fas fa-briefcase mr-2 text-blue-200"></i>Praktik
                    </a>
                    <a href="{{ route('home') }}#contact" class="nav-link hover:text-blue-200 transition-colors duration-300 flex items-center">
                        <i class="fas fa-envelope mr-2 text-blue-200"></i>Kontak
                    </a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                       class="bg-white text-blue-800 px-4 py-2 rounded-md font-medium hover:bg-gray-100 transition flex items-center shadow hover:shadow-md">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-600 transition flex items-center shadow hover:shadow-md">
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </a>

                    <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}#about" class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition flex items-center">
                        <i class="fas fa-info-circle mr-3 text-blue-200"></i>Tentang Praktik
                    </a>
                    <a href="{{ route('home') }}#recommendation" class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition flex items-center">
                        <i class="fas fa-file-signature mr-3 text-blue-200"></i>Rekomendasi Mandiri
                    </a>
                    <a href="{{ route('home') }}#praktik" class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition flex items-center">
                        <i class="fas fa-briefcase mr-3 text-blue-200"></i>Praktik Profesional
                    </a>
                    <a href="{{ route('home') }}#contact" class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition flex items-center">
                        <i class="fas fa-envelope mr-3 text-blue-200"></i>Kontak Kami
                    </a>

                    <a href="{{ route('login') }}"
                       class="bg-white text-blue-800 px-3 py-2 rounded-md font-medium hover:bg-gray-100 transition flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-blue-500 text-white px-3 py-2 rounded-md font-medium hover:bg-blue-600 transition flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white pt-12 pb-6">
    </footer>

    <button id="back-to-top"
        class="fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-blue-700">
        <i class="fas fa-arrow-up"></i>
    </button>

    @stack('scripts')

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>

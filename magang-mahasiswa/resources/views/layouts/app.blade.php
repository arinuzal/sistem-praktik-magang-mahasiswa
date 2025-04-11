<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Praktik Magang Mahasiswa - Universitas Anda">

    <title>@yield('title', 'Sistem Praktik Magang')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans antialiased">
    <!-- Header/Navbar -->
    <header class="bg-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo Brand -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                            class="h-10 w-10 rounded-full bg-white p-1 border border-gray-300 shadow" />
                        <span class="ml-2 text-xl font-bold hidden sm:inline-block text-white">Sistem Praktik
                            Magang Mahasiswa</span>
                    </a>
                </div>


                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}#about"
                        class="nav-link hover:text-blue-200 transition-colors duration-300">
                        <i class="fas fa-info-circle mr-2"></i>Tentang
                    </a>
                    <a href="{{ route('home') }}#recommendation"
                        class="nav-link hover:text-blue-200 transition-colors duration-300">
                        <i class="fas fa-file-signature mr-2"></i>Rekomendasi
                    </a>
                    <a href="{{ route('home') }}#praktik"
                        class="nav-link hover:text-blue-200 transition-colors duration-300">
                        <i class="fas fa-briefcase mr-2"></i>Praktik
                    </a>
                    <a href="{{ route('home') }}#contact"
                        class="nav-link hover:text-blue-200 transition-colors duration-300">
                        <i class="fas fa-envelope mr-2"></i>Kontak
                    </a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('mahasiswa.dashboard') }}"
                            class="bg-white text-blue-800 px-4 py-2 rounded-md font-medium hover:bg-gray-100 transition flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-white text-blue-800 px-4 py-2 rounded-md font-medium hover:bg-gray-100 transition flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700 transition flex items-center">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        @endif
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}#about"
                        class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition">
                        <i class="fas fa-info-circle mr-2"></i>Tentang Praktik
                    </a>
                    <a href="{{ route('home') }}#recommendation"
                        class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition">
                        <i class="fas fa-file-signature mr-2"></i>Rekomendasi Mandiri
                    </a>
                    <a href="{{ route('home') }}#praktik"
                        class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition">
                        <i class="fas fa-briefcase mr-2"></i>Praktik Profesional
                    </a>
                    <a href="{{ route('home') }}#contact"
                        class="nav-link hover:bg-blue-700 px-3 py-2 rounded transition">
                        <i class="fas fa-envelope mr-2"></i>Kontak Kami
                    </a>

                    @auth
                        <a href="{{ route('mahasiswa.dashboard') }}"
                            class="bg-white text-blue-800 px-3 py-2 rounded-md font-medium hover:bg-gray-100 transition flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-white text-blue-800 px-3 py-2 rounded-md font-medium hover:bg-gray-100 transition flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-blue-600 text-white px-3 py-2 rounded-md font-medium hover:bg-blue-700 transition flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <x-application-logo class="h-6 w-auto mr-2" />
                        Sistem Praktik Magang
                    </h3>
                    <p class="text-gray-400">Platform terintegrasi untuk pengelolaan praktik magang mahasiswa secara
                        efisien dan terstruktur.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition"><i
                                    class="fas fa-chevron-right mr-2 text-xs"></i>Beranda</a></li>
                        <li><a href="{{ route('home') }}#praktik"
                                class="text-gray-400 hover:text-white transition"><i
                                    class="fas fa-chevron-right mr-2 text-xs"></i>Praktik Profesional</a></li>
                        <li><a href="{{ route('home') }}#recommendation"
                                class="text-gray-400 hover:text-white transition"><i
                                    class="fas fa-chevron-right mr-2 text-xs"></i>Rekomendasi</a></li>
                        <li><a href="{{ route('home') }}#contact" class="text-gray-400 hover:text-white transition"><i
                                    class="fas fa-chevron-right mr-2 text-xs"></i>Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Kontak Kami</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>Jl. Universitas No. 1, Kota Anda, Indonesia</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3"></i>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>praktik@univ.ac.id</span>
                        </li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Media Sosial</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition text-2xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-2xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-2xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-2xl">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-400 mb-2">Subscribe newsletter:</p>
                        <form class="flex">
                            <input type="email" placeholder="Email Anda"
                                class="px-3 py-2 bg-gray-700 text-white rounded-l focus:outline-none focus:ring-1 focus:ring-blue-500 w-full">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700 transition">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} Sistem Praktik Magang Mahasiswa
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition text-sm">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-400 hover:text-white transition text-sm">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-400 hover:text-white transition text-sm">FAQ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
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

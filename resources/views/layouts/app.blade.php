<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', config('site.name')) }}</title>

        @isset($meta)
            {{ $meta }}
        @else
            <meta name="description" content="Empowering communities through seamless digital giving.">
        @endisset

        @yield('meta')

        <!-- Tailwind CSS (via CDN) -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            .glass {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .bg-glass-gradient {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 100%);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            .animate-float { animation: float 6s ease-in-out infinite; }
            .animate-float-delayed { animation: float 8s ease-in-out infinite; animation-delay: 2s; }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-20px); }
            }
            .text-shadow-premium { text-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen">
        
        <!-- Background Blobs -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <img src="{{ asset('images/brand/hero.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-[0.08] blur-2xl transform scale-150">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-100 opacity-60"></div>
            <div class="absolute top-0 -left-4 w-[500px] h-[500px] bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-[500px] h-[500px] bg-emerald-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-[500px] h-[500px] bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 flex flex-col min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="pt-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="glass rounded-3xl p-6 shadow-sm border border-white/40">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
        <x-chat-icon />
        @stack('scripts')
    </body>
</html>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skillab — @yield('title', 'Welcome')</title>
    <link rel="shortcut icon" href="{{ asset('images/logo/logo.png') }}" type="image/x-icon">

    {{-- Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind CDN --}}
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Poppins', sans-serif;
            --color-brand-light:  #F4F8FF;
            --color-brand-dark:   #002981;
            --color-brand-purple: #A82ECA;
            --color-brand-green:  #0DCF41;
        }

        .grid-bg {
            background-image: linear-gradient(to right, rgba(0,41,129,.07) 1px, transparent 1px),
                            linear-gradient(to bottom, rgba(0,41,129,.07) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%       { transform: translateY(-10px) rotate(15deg); }
        }
        .asterisk-float { animation: float 4s ease-in-out infinite; }
        .asterisk-float-delay { animation: float 4s ease-in-out 1.5s infinite; }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.94) translateY(10px); }
            to   { opacity: 1; transform: scale(1)    translateY(0); }
        }
        .modal-enter { animation: modalIn 0.25s cubic-bezier(0.16,1,0.3,1) both; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .flash-enter { animation: slideDown 0.2s ease both; }
    </style>
</head>
<body class="min-h-screen bg-brand-light font-sans antialiased">
    @unless (View::hasSection('hide_navbar'))
        @include('layouts.navbar')
    @endunless

    @auth
        @unless(request()->routeIs('home') || request()->routeIs('login') || request()->routeIs('register'))
            @include('layouts.sidebar')
        @endunless
    @endauth

    {{-- FLASH MESSAGES --}}
    <div class="fixed top-20 right-4 z-40 flex flex-col gap-2" id="flash-container">
        @if(session('success'))
            <div class="flash-enter bg-white border border-brand-green/25 rounded-2xl shadow-lg px-5 py-3 flex items-center gap-3 text-sm text-brand-dark max-w-xs">
                <span class="text-brand-green font-bold">✓</span>
                <span class="flex-1">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-brand-dark/25 hover:text-brand-dark/60">✕</button>
            </div>
        @endif
        @if(session('info'))
            <div class="flash-enter bg-white border border-brand-purple/25 rounded-2xl shadow-lg px-5 py-3 flex items-center gap-3 text-sm text-brand-dark max-w-xs">
                <span class="text-brand-purple font-bold">ℹ</span>
                <span class="flex-1">{{ session('info') }}</span>
                <button onclick="this.parentElement.remove()" class="text-brand-dark/25 hover:text-brand-dark/60">✕</button>
            </div>
        @endif
        @if(session('error'))
            <div class="flash-enter bg-white border border-red-200 rounded-2xl shadow-lg px-5 py-3 flex items-center gap-3 text-sm text-brand-dark max-w-xs">
                <span class="text-red-400 font-bold">✕</span>
                <span class="flex-1">{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-brand-dark/25 hover:text-brand-dark/60">✕</button>
            </div>
        @endif
    </div>

    @yield('content')

    @unless (View::hasSection('hide_footer'))
        @include('layouts.footer')
    @endunless
    
    <script>
        setTimeout(() => {
            document.querySelectorAll('#flash-container > div').forEach(el => el.remove());
        }, 4000);
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('translate-x-full');
            const overlay = document.getElementById('sidebar-overlay');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('translate-x-full');
            const overlay = document.getElementById('sidebar-overlay');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
    </script>
    
    @stack('scripts')
</body>
</html>
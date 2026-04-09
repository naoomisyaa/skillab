@extends('layouts.app')
@section('title', 'Home')

@section('content')
<div class="min-h-screen bg-brand-light font-sans">

<style>
@keyframes float {
    0% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(10deg); }
    100% { transform: translateY(0px) rotate(0deg); }
}
.asterisk-float {
    animation: float 4s ease-in-out infinite;
}
.asterisk-float-delay {
    animation: float 4s ease-in-out infinite;
    animation-delay: 1s;
}
html {
    scroll-behavior: smooth;
}
</style>

{{-- HERO --}}
<section class="relative min-h-[92vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 pointer-events-none"
         style="background-image:linear-gradient(to right,rgba(0,41,129,.07) 1px,transparent 1px),
                                 linear-gradient(to bottom,rgba(0,41,129,.07) 1px,transparent 1px);
                background-size:42px 42px;">
    </div>

    <span class="asterisk-float absolute top-[21%] left-[9%] text-brand-green text-5xl font-black">✦</span>
    <span class="asterisk-float-delay absolute bottom-[26%] right-[9%] text-brand-purple text-5xl font-black">✦</span>

    <div class="relative z-10 text-center px-6"
         data-aos="zoom-out" data-aos-duration="1000">

        <h1 class="text-5xl sm:text-6xl md:text-7xl font-black leading-tight mb-4 tracking-tight
                  bg-gradient-to-r from-brand-dark via-brand-purple to-brand-green
                  bg-clip-text text-transparent">
            Connect, Swap, Level Up!
        </h1>

        <p class="text-brand-dark text-base sm:text-2xl mb-10 font-light">
            skill laboratory and barter.
        </p>

  @auth
                <a href="{{ route('matchmaking.index') }}"
                   class="inline-block px-14 py-3 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                          hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                    explore!
                </a>
            @else
                <button onclick="openLoginModal()"
                   class="px-14 py-3 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                          hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                    explore!
                </button>
            @endauth
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none"
         style="background-image:linear-gradient(to right,rgba(0,41,129,.07) 1px,transparent 1px),
                                 linear-gradient(to bottom,rgba(0,41,129,.07) 1px,transparent 1px);
                background-size:42px 42px;">
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div data-aos="fade-right">
            <h2 class="text-6xl sm:text-7xl font-black leading-[1.5]
                      bg-gradient-to-b from-brand-dark to-brand-purple
                      bg-clip-text text-transparent">
                How<br>Skillab<br>works?
            </h2>
        </div>

        <div data-aos="fade-left" data-aos-delay="200">
            <p class="text-brand-dark/65 text-lg leading-relaxed text-right">
                skillab works as your skill-laboratory,<br>
                as you can list your skill, match with others<br>
                then swap or build project together in a<br>
                healthy community
            </p>
        </div>
    </div>
</section>

{{-- CARDS --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none"
         style="background-image:linear-gradient(to right,rgba(0,41,129,.07) 1px,transparent 1px),
                                 linear-gradient(to bottom,rgba(0,41,129,.07) 1px,transparent 1px);
                background-size:42px 42px;">
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-8 grid grid-cols-1 sm:grid-cols-2 gap-8">

        <div class="bg-white rounded-3xl shadow-xl p-10 text-center flex flex-col items-center gap-6 hover:scale-105 transition"
             data-aos="flip-left">

            <h3 class="text-6xl font-black bg-gradient-to-br from-[#6A1581] to-brand-dark bg-clip-text text-transparent">
                Swap a<br>Skill
            </h3>

            <p class="text-brand-purple text-sm font-semibold">
                Find your partner in skill<br>and exchange
            </p>
            @auth
                    <a href="{{ route('matchmaking.index') }}"
                       class="px-10 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                              hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                        go
                    </a>
                @else
                    <button onclick="openLoginModal()"
                       class="px-10 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                              hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                        go
                    </button>
                @endauth
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-10 text-center flex flex-col items-center gap-6 hover:scale-105 transition"
             data-aos="flip-right" data-aos-delay="200">

            <h3 class="text-6xl font-black bg-gradient-to-br from-brand-dark to-[#1D8115] bg-clip-text text-transparent">
                Make a<br>Project!
            </h3>

            <p class="text-[#1D8115] text-sm font-semibold">
                Join a project with a<br>skilled partner
            </p>
            <button onclick="document.getElementById('premium-section').scrollIntoView({behavior:'smooth'})"
                   class="px-10 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                          hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                    go
                </button>
        </div>

    </div>
</section>

{{-- PREMIUM --}}
<section id="premium-section" class="relative py-24 overflow-hidden"
         data-aos="zoom-in-up">

    <div class="relative z-10 max-w-4xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="flex justify-center">
            <div class="space-y-4">
                <p class="w-full sm:w-52 text-brand-dark text-lg sm:text-xl text-center sm:text-start leading-relaxed font-medium">
                    For only
                    <span class="text-[#1D8115] font-bold">9.99$</span>
                    you can get the ease and access more feature,
                    including our very special
                </p>
                <p class="text-2xl font-black tracking-wide text-center sm:text-start
                          bg-gradient-to-r from-brand-dark via-brand-purple to-[#1D8115]
                          bg-clip-text text-transparent">
                    MAKE A PROJECT!
                </p>
            </div>
          </div>

            <div class="flex flex-col items-center md:items-end gap-6">
                <h2 class="text-5xl sm:text-6xl font-black leading-tight text-center md:text-right
                          bg-gradient-to-b from-brand-purple to-[#1D8115]
                          bg-clip-text text-transparent">
                    Join Our<br>Premium!
                </h2>
                <button class="px-12 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                               hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                    Join!
                </button>
            </div>

</section>



{{-- AOS --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

@guest
<div id="login-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-brand-dark/25 backdrop-blur-sm"
         onclick="closeLoginModal()">
    </div>

    {{-- Card --}}
    <div class="relative z-10 bg-white rounded-3xl shadow-2xl px-10 py-12 w-full max-w-sm text-center"
         style="animation: modalIn 0.25s cubic-bezier(0.16,1,0.3,1) both">
        <span class="text-5xl block">🔐</span>
        <h3 class="text-2xl font-bold text-brand-dark mt-4 mb-1">
            Log in <span class="text-brand-purple">to continue</span>
        </h3>
        <p class="text-brand-dark/65 text-sm mb-8">
            Please log in to explore Skillab.
        </p>
        <div class="flex gap-3">
            <a href="{{ route('login') }}"
               class="flex-1 py-2 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                      hover:bg-brand-dark hover:text-white transition-all duration-200">
                Login
            </a>
        </div>
        <button onclick="closeLoginModal()"
                class="mt-5 text-xs text-brand-dark/45 hover:text-brand-dark/60 transition-colors duration-150">
            Not now
        </button>
    </div>
</div>

<style type="text/tailwindcss">
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1)    translateY(0); }
    }
</style>

<script>

    AOS.init({
    duration: 800,
    once: true
});

    function openLoginModal()  { document.getElementById('login-modal').classList.remove('hidden'); }
    function closeLoginModal() { document.getElementById('login-modal').classList.add('hidden'); }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLoginModal();
    });
</script>
@endguest

@endsection
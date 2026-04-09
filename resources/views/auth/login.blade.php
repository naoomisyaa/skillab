@extends('layouts.app')
@section('title', 'Login')
@section('hide_navbar', true)
@section('hide_footer', true)

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-brand-light">
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: linear-gradient(to right, rgba(0,41,129,0.07) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(0,41,129,0.07) 1px, transparent 1px);
                background-size: 42px 42px;">
    </div>

    <span class="asterisk-float absolute top-[18%] left-[11%] text-brand-green text-5xl font-bold select-none leading-none">
        &#42;
    </span>

    <span class="asterisk-float-delay absolute bottom-[25%] right-[11%] text-brand-purple text-5xl font-bold select-none leading-none">
        &#42;
    </span>

    <div class="relative z-10 bg-white rounded-3xl shadow-xl shadow-brand-dark/10 px-10 py-12 w-full max-w-sm mx-4">

        <h1 class="text-4xl font-bold text-center mb-8 tracking-tight">
            <span class="text-brand-purple">Log </span><span class="text-brand-dark">In</span>
        </h1>

        @if ($errors->any())
            <div class="mb-5 p-3 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-500 space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 p-3 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-500">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="username"
                    autocomplete="username"
                    autofocus
                    class="w-full bg-brand-light rounded-2xl px-5 py-3.5 text-sm text-brand-dark placeholder-brand-dark/35 outline-none border-2 border-transparent focus:border-brand-dark/20 transition-all duration-200 @error('email') border-red-300 @enderror"
                >
            </div>

            <div class="relative">
                <input type="password" name="password" id="inp-login-password"
                    placeholder="password"
                    autocomplete="current-password"
                    class="w-full bg-brand-light rounded-2xl px-5 py-3.5 pr-12 text-sm text-brand-dark placeholder-brand-dark/35 outline-none border-2 border-transparent focus:border-brand-dark/20 transition-all duration-200 @error('password') border-red-300 @enderror">
                <button type="button" onclick="togglePassword('inp-login-password', 'eye-login-password')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-dark/30 hover:text-brand-dark/60 transition-colors">
                    <svg id="eye-login-password" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <div class="flex items-center gap-2 px-1">
                <input type="checkbox" name="remember" id="remember"
                    class="rounded accent-brand-dark w-3.5 h-3.5">
                <label for="remember" class="text-xs text-brand-dark/50 cursor-pointer">
                    Remember me
                </label>
            </div>

            <div class="flex justify-center pt-3">
                <button type="submit"
                    class="px-12 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-medium
                           hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                    go
                </button>
            </div>
        </form>

        <p class="text-center text-xs text-brand-dark/40 mt-7">
            Don't have an account?
            <a href="{{ route('register') }}"
               class="text-brand-purple font-semibold hover:underline underline-offset-2">
                Register here
            </a>
        </p>

    </div>
</div>
@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    const isHidden = input.type === 'password';

    input.type = isHidden ? 'text' : 'password';

    // Ganti icon: eye ↔ eye-off
    icon.innerHTML = isHidden
        ? // Eye-off (password visible)
          `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
        : // Eye (password hidden)
          `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
           <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
}
</script>
@endpush
@endsection
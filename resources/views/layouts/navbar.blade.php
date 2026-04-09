<nav class="sticky top-0 z-50 bg-brand-light/90 backdrop-blur-sm shadow-md border-b border-brand-dark/5">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

      {{-- Logo --}}
      <a href="{{ route('home') }}" class="flex items-center gap-2 group">
          <img src="{{ asset('images/logo/logo_skill_lab.png') }}" alt="logo skill lab" class="w-36 h-auto">
      </a>

      {{-- Links --}}
        @if(request()->routeIs('home') || request()->routeIs('login') || request()->routeIs('register'))
            <div class="flex items-center gap-7 text-medium font-semibold">
                <a href="#how-it-works"
                    class="text-brand-dark hover:text-brand-purple transition-colors duration-150">
                    how it works
                </a>
                <a href="#premium-section"
                    class="text-brand-dark hover:text-brand-purple transition-colors duration-150">
                    us
                </a>
                @auth
                    <a href="{{ route('matchmaking.index') }}"
                        class="text-brand-green font-semibold hover:underline underline-offset-2">
                        explore
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="text-brand-green font-semibold hover:underline underline-offset-2">
                        register
                    </a>
                @endauth
            </div>
        @else
        <button onclick="openSidebar()"
                class="flex flex-col gap-1.5 p-2 rounded-xl hover:bg-brand-dark/5 active:scale-95 transition-all group"
                aria-label="Open menu">
            <span class="block w-6 h-0.5 bg-brand-dark transition-all group-hover:bg-brand-purple"></span>
            <span class="block w-4 h-0.5 bg-brand-dark transition-all group-hover:bg-brand-purple"></span>
            <span class="block w-6 h-0.5 bg-brand-dark transition-all group-hover:bg-brand-purple"></span>
        </button>
        @endif
  </div>
</nav>
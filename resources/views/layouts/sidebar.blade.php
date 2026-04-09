<div id="sidebar-overlay"
     class="fixed inset-0 bg-brand-dark/20 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300"
     onclick="closeSidebar()">
</div>
<aside id="sidebar"
       class="fixed top-0 right-0 h-full w-72 bg-white z-50 shadow-2xl shadow-brand-dark/20
              transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">

    <div class="flex items-center justify-between px-6 py-4 border-b-2 border-brand-dark/10">
        <img src="{{ asset('images/logo/logo_skill_lab.png') }}" alt="logo skill lab" class="w-24 h-auto">
        <button onclick="closeSidebar()"
                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-light transition-colors text-brand-dark/40 hover:text-brand-dark">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>


    <div class="px-6 py-5 border-b-2 border-brand-dark/10">
        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->profile_photo_url }}"
                 alt="{{ auth()->user()->name }}"
                 class="w-12 h-12 rounded-full object-cover border-2 border-brand-dark/10">
            <div class="min-w-0">
                <p class="font-bold text-brand-dark text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-brand-dark/40 truncate">@ {{ auth()->user()->username }}</p>
            </div>
        </div>
    </div>


    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">

        <a href="{{ route('matchmaking.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-150
                  {{ request()->routeIs('matchmaking.*')
                      ? 'bg-brand-dark text-white'
                      : 'text-brand-dark/60 hover:bg-brand-light hover:text-brand-dark' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Explore
        </a>

        <a href="{{ route('collaboration-requests.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-150
                  {{ request()->routeIs('collaboration-requests.*')
                      ? 'bg-brand-dark text-white'
                      : 'text-brand-dark/60 hover:bg-brand-light hover:text-brand-dark' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="flex-1">Collaboration Requests</span>
            @php $pendingCount = auth()->user()->receivedRequests()->pending()->count(); @endphp
            @if($pendingCount > 0)
                <span class="bg-brand-purple text-white text-[9px] font-bold min-w-[18px] h-[18px] px-1 rounded-full flex items-center justify-center">
                    {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                </span>
            @endif
        </a>

         <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-150
                  {{ request()->routeIs('#')
                      ? 'bg-brand-dark text-white'
                      : 'text-brand-dark/60 hover:bg-brand-light hover:text-brand-dark' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
            </svg>
            <span class="flex-1">Make a Project</span>
        </a>

    </nav>


    <div class="px-4 py-4 border-t border-brand-dark/8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-red-400
                           hover:bg-red-50 hover:text-red-500 transition-all duration-150">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
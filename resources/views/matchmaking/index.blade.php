@extends('layouts.app')
@section('hide_footer', true)
@section('title', 'Explore')

@section('content')
<div class="relative min-h-screen bg-brand-light">
    <div class="absolute inset-0 grid-bg pointer-events-none"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-5 py-8">       
        {{-- ── Search + Filter bar ────────────────────────────────── --}}
        <div class="flex gap-3 mb-6">
            <form method="GET" action="{{ route('matchmaking.index') }}"
                  class="flex-1 relative" id="search-form">
                <input type="hidden" name="skill" value="{{ request('skill') }}">
                {{-- Search icon --}}
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-brand-dark/35 pointer-events-none"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="look up what you need!"
                       class="w-full bg-white border-2 border-brand-dark/15 rounded-full shadow-sm pl-11 pr-5 py-3
                              text-sm text-brand-dark placeholder-brand-dark/35
                              outline-none focus:border-brand-dark/40 transition-all duration-200">
            </form>

            <button onclick="toggleFilter()"
                    id="filter-btn"
                    class="w-12 h-12 rounded-full border-2 border-brand-dark/15 bg-white shadow-sm flex items-center justify-center
                           hover:border-brand-purple/40 hover:text-brand-purple text-brand-dark/40 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
            </button>
        </div>

        {{-- ── Skill filter pills (collapsible) ──────────────────── --}}
        @if($skills->isNotEmpty())
        <div id="filter-panel" class="{{ request('skill') ? '' : 'hidden' }} mb-5">
            <div class="flex flex-wrap gap-2 bg-white border-2 border-brand-dark/10 rounded-3xl p-4">
                <a href="{{ route('matchmaking.index', array_merge(request()->except('skill','page'), [])) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold border-2 transition-all duration-150
                          {{ !request('skill') ? 'border-brand-dark bg-brand-dark text-white' : 'border-brand-dark/15 text-brand-dark/50 hover:border-brand-dark/30' }}">
                    Semua
                </a>
                @foreach($skills as $skill)
                    <a href="{{ route('matchmaking.index', array_merge(request()->except('page'), ['skill' => $skill->slug])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-semibold border-2 transition-all duration-150
                              {{ request('skill') === $skill->slug
                                  ? 'border-brand-purple bg-brand-purple text-white'
                                  : 'border-brand-dark/15 text-brand-dark/50 hover:border-brand-purple/40 hover:text-brand-purple' }}">
                        {{ $skill->name }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Results count ──────────────────────────────────────── --}}
        @if(request('search') || request('skill'))
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs text-brand-dark/45">
                {{ $users->total() }} users found
                @if(request('search')) for "<strong>{{ request('search') }}</strong>" @endif
            </p>
            <a href="{{ route('matchmaking.index') }}" class="text-xs text-brand-purple hover:underline">
                Reset
            </a>
        </div>
        @endif

        {{-- ── Cards Grid ─────────────────────────────────────────── --}}
        @if($users->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <span class="text-6xl mb-5">🔍</span>
                <h3 class="text-xl font-bold text-brand-dark mb-2">No users found</h3>
                <p class="text-brand-dark/40 text-sm mb-6">
                    Try adjusting your keywords or skill filters.
                </p>
                <a href="{{ route('matchmaking.index') }}"
                class="px-8 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark text-sm font-semibold
                        hover:bg-brand-dark hover:text-white transition-all duration-200">
                    View all
                </a>
            </div>
        @else
            {{-- Placeholder Project Cards --}}
            <div class="mb-8">
                <div class="flex items-baseline gap-2 justify-between mb-4">
                    <h2 class="text-2xl font-black text-black">
                        We've got some project suited you, take a look!
                    </h2>
                    <a href="#" class="text-xs text-brand-dark/75 hover:text-brand-purple transition-colors">
                        see more..
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach([
                        ['title' => 'Weathfit', 'status' => 'unpaid', 'grad' => 'from-brand-purple via-[#7B5EA7] to-[#3ABFB0]', 'ring' => false],
                        ['title' => 'Weathfit', 'status' => 'paid',   'grad' => 'from-[#3ABFB0] via-[#4DC87A] to-brand-green',  'ring' => false],
                        ['title' => 'Weathfit', 'status' => 'paid',   'grad' => 'from-[#4DC87A] via-[#3ABFB0] to-brand-purple', 'ring' => false],
                        ['title' => 'Weathfit', 'status' => 'unpaid', 'grad' => 'from-brand-purple via-[#9B59B6] to-[#4DC87A]', 'ring' => false],
                    ] as $card)
                    <div class="relative bg-gradient-to-br {{ $card['grad'] }} rounded-3xl p-5 overflow-hidden
                                {{ $card['ring'] ? 'ring-2 ring-brand-dark ring-offset-1' : '' }}
                                cursor-pointer hover:scale-[1.02] hover:shadow-xl hover:shadow-brand-dark/15 transition-all duration-200">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-black text-white">{{ $card['title'] }}</h3>
                            <p class="text-white/75 text-sm font-medium mt-1">{{ $card['status'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-6">
                <h1 class="text-2xl font-black text-black">
                    Match & Swap Your Skills
                </h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                @foreach($users as $user)
                @php
                    $hasPending  = in_array($user->id, $pendingRequestedIds);
                    $yourSkill   = $user->skills->first();
                    $neededSkill = $user->neededSkills->first();
                    $userData    = [
                        'id'                => $user->id,
                        'name'              => $user->name,
                        'username'          => $user->username,
                        'phone_number'      => preg_replace('/\D/', '', $user->phone_number ?? ''),
                        'gender'            => $user->gender,
                        'bio'               => $user->bio,
                        'member_since'      => $user->created_at->format('M Y'),
                        'profile_photo_url' => $user->profile_photo_url,
                        'portfolio_pdf_url' => $user->portfolio_pdf_url,
                        'whatsapp_url'      => $user->whatsapp_url,
                        'skills'            => $user->skills->map(fn($s) => ['id' => $s->id, 'name' => $s->name]),
                        'needed_skills'     => $user->neededSkills->map(fn($s) => ['id' => $s->id, 'name' => $s->name]),
                        'has_pending'       => $hasPending,
                    ];
                @endphp

                <div class="bg-white border-2 {{ $hasPending ? 'border-brand-green/40' : 'border-brand-dark/20' }}
                            rounded-3xl overflow-hidden cursor-pointer
                            hover:border-brand-purple/50 hover:shadow-lg hover:shadow-brand-dark/10 hover:-translate-y-1
                            transition-all duration-200"
                     onclick="openModal(this)"
                     data-user='@json($userData)'>

                    {{-- Photo --}}
                    <div class="relative h-44 bg-gray-100 overflow-hidden">
                        <img src="{{ $user->profile_photo_url }}"
                             alt="{{ $user->name }}"
                             loading="lazy"
                             width="200" height="176"
                             class="w-full h-full object-cover object-top">

                        {{-- Pending badge overlay --}}
                        @if($hasPending)
                        <div class="absolute top-2 right-2 bg-brand-green text-white text-[9px] font-bold px-2 py-0.5 rounded-full">
                            Requested
                        </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="px-4 py-3.5">
                        <h3 class="font-bold text-brand-dark text-sm leading-tight truncate">
                            {{ $user->name }}
                        </h3>

                        {{-- Skill swap indicator --}}
                        @if($yourSkill || $neededSkill)
                        <p class="text-xs font-semibold mt-1 flex items-center gap-1 truncate">
                            <span class="text-brand-purple truncate">{{ $yourSkill?->name ?? '—' }}</span>
                            <span class="text-brand-dark/30 shrink-0">⇄</span>
                            <span class="text-brand-green truncate">{{ $neededSkill?->name ?? '—' }}</span>
                        </p>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                {{ $users->links('vendor.pagination.custom-dots') }}
            @endif
        @endif

    </div>
</div>

{{-- ══ USER DETAIL MODAL ══════════════════════════════════════════════════ --}}
<div id="user-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-brand-dark/20 backdrop-blur-sm" onclick="closeModal()"></div>

    <div id="modal-card"
         class="modal-enter relative z-10 bg-white rounded-3xl shadow-2xl shadow-brand-dark/15
                w-full max-w-sm max-h-[92vh] overflow-y-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden border-2 border-brand-dark/10">

        {{-- Close --}}
        <button onclick="closeModal()"
                class="absolute top-3 right-3 z-10 w-8 h-8 flex items-center justify-center rounded-full
                       bg-white/80 backdrop-blur-sm text-brand-dark/40 hover:text-brand-dark hover:bg-white transition-all shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Profile photo hero --}}
        <div class="relative h-52 bg-gray-100 overflow-hidden rounded-t-3xl">
            <img id="modal-photo" src="" alt="" width="400" height="208"
                 class="w-full h-full object-cover object-top">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent"></div>
            <div class="absolute bottom-4 left-5 right-5">
                <h2 id="modal-name"
                    class="text-xl font-black text-white leading-tight pb-0.5 drop-shadow"></h2>
                <p id="modal-meta" class="text-xs text-white/70"></p>
            </div>
        </div>

        <div class="px-4 py-5 space-y-5">

            {{-- Skill Swap display --}}
            <div id="modal-skills-swap" class="flex items-center justify-center gap-3 py-2 px-2 rounded-md bg-brand-light">
                <div class="text-center flex-1">
                    <p class="text-[10px] text-brand-dark/40 uppercase tracking-widest mb-1">Has Skills</p>
                    <div id="modal-has-skills" class="flex flex-wrap gap-1 justify-center"></div>
                </div>
                <div class="text-brand-dark/20 text-xl font-bold shrink-0">⇄</div>
                <div class="text-center flex-1">
                    <p class="text-[10px] text-brand-dark/40 uppercase tracking-widest mb-1">Needs Skills</p>
                    <div id="modal-needs-skills" class="flex flex-wrap gap-1 justify-center"></div>
                </div>
            </div>

            {{-- Bio --}}
            <div>
                <p class="text-[10px] font-semibold text-brand-dark/35 uppercase tracking-widest mb-1.5">Bio</p>
                <p id="modal-bio" class="text-sm text-brand-dark/60 leading-relaxed"></p>
            </div>

            {{-- Portfolio --}}
            <div id="modal-portfolio-section" class="hidden">
                <p class="text-[10px] font-semibold text-brand-dark/35 uppercase tracking-widest mb-1.5">Portfolio</p>
                <a id="modal-portfolio-link" href="#" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-brand-light border border-brand-dark/10
                          text-xs font-medium text-brand-dark hover:border-brand-purple/30 hover:text-brand-purple transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    View Portfolio PDF
                </a>
            </div>

            {{-- Collaboration form --}}
            <div>
                <p class="text-[10px] font-semibold text-brand-dark/35 uppercase tracking-widest mb-1.5">Pesan (opsional)</p>

                <form id="contact-form" method="POST" action="{{ route('collaboration-requests.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="requested_id" id="modal-requested-id">
                    <input type="hidden" id="modal-wa-number">
                    <textarea name="message" id="modal-message"
                              placeholder="Introduce yourself or share your collaboration idea..."
                              rows="3" maxlength="500"
                              class="w-full bg-brand-light rounded-2xl px-4 py-3 text-sm text-brand-dark
                                     placeholder-brand-dark/30 outline-none border-2 border-transparent
                                     focus:border-brand-dark/20 transition-all resize-none mb-3"></textarea>

                    <button type="button" id="btn-contact-wa"
                            class="w-full py-3 rounded-full bg-brand-dark text-white text-sm font-bold
                                   hover:bg-brand-dark/85 active:scale-95 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.985-1.309A9.956 9.956 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                        </svg>
                        Contact via WhatsApp
                    </button>
                </form>

                <div id="modal-pending-state" class="hidden">
                    <div class="w-full py-3 rounded-full bg-brand-green/8 border-2 border-brand-green/20 text-brand-green text-sm font-bold text-center">
                        ⏳ Request Terkirim
                    </div>
                    <p class="text-center text-xs text-brand-dark/35 mt-2">Menunggu persetujuan.</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Filter toggle ──────────────────────────────────────────────
    function toggleFilter() {
        const panel = document.getElementById('filter-panel');
        const btn   = document.getElementById('filter-btn');
        panel.classList.toggle('hidden');
        btn.classList.toggle('border-brand-purple/40');
        btn.classList.toggle('text-brand-purple');
    }

    @if(request('skill'))
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('filter-panel')?.classList.remove('hidden');
        });
    @endif

    // ── Modal ──────────────────────────────────────────────────────
    function openModal(card) {
        const user = JSON.parse(card.dataset.user);

        document.getElementById('modal-photo').src         = user.profile_photo_url;
        document.getElementById('modal-photo').alt         = user.name;
        document.getElementById('modal-name').textContent  = user.name;
        document.getElementById('modal-meta').textContent  = `@${user.username} · ${user.gender} · Since ${user.member_since}`;
        document.getElementById('modal-bio').textContent   = user.bio || 'No bio available.';
        document.getElementById('modal-requested-id').value = user.id;
        document.getElementById('modal-message').value     = '';
        document.getElementById('modal-wa-number').value = user.phone_number || '';

        // Has skills tags
        const hasEl = document.getElementById('modal-has-skills');
        hasEl.innerHTML = user.skills.length
            ? user.skills.map(s =>
                `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-brand-purple/10 text-brand-purple border border-brand-purple/15">${s.name}</span>`
              ).join('')
            : `<span class="text-[10px] text-brand-dark/35">—</span>`;

        // Needs skills tags
        const needsEl = document.getElementById('modal-needs-skills');
        needsEl.innerHTML = user.needed_skills.length
            ? user.needed_skills.map(s =>
                `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-brand-green/10 text-brand-green border border-brand-green/20">${s.name}</span>`
              ).join('')
            : `<span class="text-[10px] text-brand-dark/35">—</span>`;

        // Portfolio
        const pSection = document.getElementById('modal-portfolio-section');
        const pLink    = document.getElementById('modal-portfolio-link');
        if (user.portfolio_pdf_url) {
            pLink.href = user.portfolio_pdf_url;
            pSection.classList.remove('hidden');
        } else {
            pSection.classList.add('hidden');
        }

        // Pending state
        const contactForm  = document.getElementById('contact-form');
        const pendingState = document.getElementById('modal-pending-state');
        if (user.has_pending) {
            contactForm.classList.add('hidden');
            pendingState.classList.remove('hidden');
        } else {
            contactForm.classList.remove('hidden');
            pendingState.classList.add('hidden');
        }

        // Show modal
        const modal = document.getElementById('user-modal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Re-trigger animation
        const mc = document.getElementById('modal-card');
        mc.classList.remove('modal-enter');
        void mc.offsetWidth;
        mc.classList.add('modal-enter');
    }

    function closeModal() {
        document.getElementById('user-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    document.getElementById('btn-contact-wa').addEventListener('click', function () {
        const number  = document.getElementById('modal-wa-number').value;
        const message = document.getElementById('modal-message').value.trim();

        let waUrl = `https://wa.me/${number}`;
        if (message) {
            waUrl += `?text=${encodeURIComponent(message)}`;
        }

        if (number) {
            window.open(waUrl, '_blank', 'noopener,noreferrer');
        }

        document.getElementById('contact-form').submit();
    });
</script>
@endpush
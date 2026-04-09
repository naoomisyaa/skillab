@extends('layouts.app')

@section('title', 'Collaboration Requests')

@section('content')
<div class="min-h-screen grid-bg">
    <div class="max-w-6xl mx-auto px-5 py-10">
        <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-0 sm:items-center sm:justify-between mb-4 sm:mb-8">
          <div>
            <h1 class="text-2xl font-black text-brand-dark">Collaboration Requests</h1>
            <p class="text-sm text-brand-dark/40 mt-1">
                Manage incoming and outgoing collaboration requests
            </p>
          </div>

          <button onclick="refreshRequests()"
                  id="refresh-btn"
                  class="flex items-center gap-2 px-4 py-2 bg-white cursor-pointer rounded-full border-2 border-brand-dark/10
                        text-brand-dark/50 text-xs font-semibold
                        hover:border-brand-dark/25 hover:text-brand-dark
                        active:scale-95 transition-all duration-150">
              <svg id="refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              Refresh
          </button>
        </div>

        <div class="flex gap-2 mb-6 bg-white border-2 border-brand-dark/8 rounded-2xl p-1.5 w-fit">
            <button onclick="switchTab('received')" id="tab-received"
                    class="tab-btn px-5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                           bg-brand-dark text-white">
                Received
                @if($receivedRequests->where('status->value', 'pending')->count() > 0 ||
                    $receivedRequests->filter(fn($r) => $r->status->value === 'pending')->count() > 0)
                    <span class="ml-1.5 bg-brand-purple text-white text-[9px] font-black
                                 min-w-[16px] h-4 px-1 rounded-full inline-flex items-center justify-center">
                        {{ $receivedRequests->filter(fn($r) => $r->status->value === 'pending')->count() }}
                    </span>
                @endif
            </button>
            <button onclick="switchTab('sent')" id="tab-sent"
                    class="tab-btn px-5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                           text-brand-dark/50 hover:text-brand-dark">
                Sent
            </button>
        </div>

        <div id="panel-received">
            @forelse($receivedRequests as $req)
            <div class="bg-white border-2 border-brand-dark/8 rounded-3xl p-5 mb-3
                        hover:border-brand-dark/15 hover:shadow-md hover:shadow-brand-dark/5
                        transition-all duration-200">
                <div class="flex items-start gap-4">

                    {{-- Avatar --}}
                    <img src="{{ $req->requester->profile_photo_url }}"
                         alt="{{ $req->requester->name }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-brand-dark/8 shrink-0">

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2 flex-wrap">
                            <div>
                                <p class="font-bold text-brand-dark text-sm leading-tight">
                                    {{ $req->requester->name }}
                                </p>
                                <p class="text-[11px] text-brand-dark/50 mt-0.5">
                                    @ {{ $req->requester->username }} · {{ $req->created_at->diffForHumans() }}
                                </p>
                            </div>

                            {{-- Status badge --}}
                            @if($req->status->value === 'pending')
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                            bg-yellow-50 text-yellow-600 border border-yellow-200 shrink-0">
                                    ⏳ Pending
                                </span>
                            @elseif($req->status->value === 'accepted')
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                            bg-brand-green/10 text-brand-green border border-brand-green/20 shrink-0">
                                    ✓ Accepted
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                            bg-red-50 text-red-400 border border-red-100 shrink-0">
                                    ✕ Rejected
                                </span>
                            @endif
                        </div>

                        {{-- Skills --}}
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach($req->requester->skills->take(3) as $skill)
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                                             bg-brand-purple/8 text-brand-purple border border-brand-purple/15">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Message --}}
                        @if($req->message)
                        <div class="mt-3 px-3.5 py-2.5 bg-brand-light rounded-2xl border border-brand-dark/8">
                            <p class="text-xs text-brand-dark/60 leading-relaxed">
                                "{{ $req->message }}"
                            </p>
                        </div>
                        @endif

                        {{-- Actions (hanya untuk pending) --}}
                        @if($req->status->value === 'pending')
                        <div class="flex gap-2 mt-4">
                            <form method="POST"
                                  action="{{ route('collaboration-requests.accept', $req) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-5 py-2 rounded-full bg-brand-dark text-white text-xs font-bold
                                               hover:bg-brand-dark/85 active:scale-95 transition-all duration-150">
                                    ✓ Accept
                                </button>
                            </form>
                            <form method="POST"
                                  action="{{ route('collaboration-requests.decline', $req) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-5 py-2 rounded-full border-2 border-red-200 text-red-400 text-xs font-bold
                                               hover:bg-red-50 hover:border-red-300 active:scale-95 transition-all duration-150">
                                    ✕ Decline
                                </button>
                            </form>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20">
                <div class="text-5xl mb-4">📭</div>
                <p class="font-bold text-brand-dark/70 text-sm">No requests yet</p>
                <p class="text-xs text-brand-dark/45 mt-1">Collaboration requests from other users will appear here</p>
            </div>
            @endforelse
        </div>

        <div id="panel-sent" class="hidden">
            @forelse($sentRequests as $req)
            <div class="bg-white border-2 border-brand-dark/8 rounded-3xl p-5 mb-3
                        hover:border-brand-dark/15 hover:shadow-md hover:shadow-brand-dark/5
                        transition-all duration-200">
                <div class="flex items-start gap-4">

                    {{-- Avatar --}}
                    <img src="{{ $req->requested->profile_photo_url }}"
                         alt="{{ $req->requested->name }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-brand-dark/8 shrink-0">

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2 flex-wrap">
                            <div>
                                <p class="font-bold text-brand-dark text-sm leading-tight">
                                    {{ $req->requested->name }}
                                </p>
                                <p class="text-[11px] text-brand-dark/50 mt-0.5">
                                    @ {{ $req->requested->username }} · {{ $req->created_at->diffForHumans() }}
                                </p>
                            </div>

                            {{-- Status badge --}}
                            @if($req->status->value === 'pending')
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                            bg-yellow-50 text-yellow-600 border border-yellow-200 shrink-0">
                                    ⏳ Awaiting Approval
                                </span>
                            @elseif($req->status->value === 'accepted')
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                            bg-brand-green/10 text-brand-green border border-brand-green/20 shrink-0">
                                    ✓ Accepted
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                            bg-red-50 text-red-400 border border-red-100 shrink-0">
                                    ✕ Rejected
                                </span>
                            @endif
                        </div>

                        {{-- Skills target user --}}
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach($req->requested->skills->take(3) as $skill)
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                                             bg-brand-green/8 text-brand-green border border-brand-green/20">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Message --}}
                        @if($req->message)
                        <div class="mt-3 px-3.5 py-2.5 bg-brand-light rounded-2xl border border-brand-dark/8">
                            <p class="text-xs text-brand-dark/60 leading-relaxed">
                                "{{ $req->message }}"
                            </p>
                        </div>
                        @endif

                        {{-- Accepted state: tampilkan tombol buka WA --}}
                        @if($req->status->value === 'accepted' && $req->requested->whatsapp_url)
                        <div class="mt-4">
                            <a href="{{ $req->requested->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 px-5 py-2 rounded-full
                                      bg-brand-green text-white text-xs font-bold
                                      hover:bg-brand-green/85 active:scale-95 transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                    <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.985-1.309A9.956 9.956 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                                </svg>
                                Chat di WhatsApp
                            </a>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20">
                <div class="text-5xl mb-4">📤</div>
                <p class="font-bold text-brand-dark/70 text-sm">No requests sent yet</p>
                <p class="text-xs text-brand-dark/45 mt-1">
                    Start exploring and send collaboration requests to other users
                </p>
                <a href="{{ route('matchmaking.index') }}"
                  class="inline-block mt-5 px-6 py-2.5 rounded-full bg-brand-dark text-white
                          text-xs font-bold hover:bg-brand-dark/85 active:scale-95 transition-all">
                    Explore Now →
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>

@push('scripts')
<script>
    const REFRESH_URL = '{{ route('collaboration-requests.api.index') }}';

    function switchTab(tab) {
        document.getElementById('panel-received').classList.toggle('hidden', tab !== 'received');
        document.getElementById('panel-sent').classList.toggle('hidden', tab !== 'sent');

        const activeClass   = ['bg-brand-dark', 'text-white'];
        const inactiveClass = ['text-brand-dark/50', 'hover:text-brand-dark'];

        const received = document.getElementById('tab-received');
        const sent     = document.getElementById('tab-sent');

        if (tab === 'received') {
            received.classList.add(...activeClass);
            received.classList.remove(...inactiveClass);
            sent.classList.remove(...activeClass);
            sent.classList.add(...inactiveClass);
        } else {
            sent.classList.add(...activeClass);
            sent.classList.remove(...inactiveClass);
            received.classList.remove(...activeClass);
            received.classList.add(...inactiveClass);
        }
    }

    @if($receivedRequests->isEmpty() && $sentRequests->isNotEmpty())
        switchTab('sent');
    @endif

    async function refreshRequests() {
    const btn  = document.getElementById('refresh-btn');
    const icon = document.getElementById('refresh-icon');

    icon.classList.add('animate-spin');
    btn.disabled = true;

    try {
        const res  = await fetch(REFRESH_URL, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
        const data = await res.json();

        const badge = document.getElementById('pending-badge');
        if (data.pending_count > 0) {
            if (badge) {
                badge.textContent = data.pending_count > 9 ? '9+' : data.pending_count;
                badge.classList.remove('hidden');
            }
        } else {
            badge?.classList.add('hidden');
        }

        window.location.reload();

    } catch (err) {
        console.error(err);
        icon.classList.remove('animate-spin');
        btn.disabled = false;
    }
}
</script>
@endpush
@endsection
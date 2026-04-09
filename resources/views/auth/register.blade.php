@extends('layouts.app')
@section('title', 'Register')
@section('hide_navbar', true)
@section('hide_footer', true)

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-brand-light py-12 px-4">

    <div class="absolute inset-0 grid-bg pointer-events-none"></div>
    <span class="asterisk-float absolute top-[14%] left-[8%] text-brand-green text-5xl font-black select-none">&#42;</span>
    <span class="asterisk-float-delay absolute bottom-[18%] right-[8%] text-brand-purple text-5xl font-black select-none">&#42;</span>

    <div class="relative z-10 w-full max-w-lg">

        <div class="flex justify-center items-center gap-2 mb-6">
            @foreach([1,2,3] as $i)
                <div class="rounded-full transition-all duration-300
                    {{ $i === $step
                        ? 'w-6 h-3 bg-brand-dark'
                        : ($i < $step
                            ? 'w-3 h-3 bg-brand-green'
                            : 'w-3 h-3 bg-brand-dark/20') }}">
                </div>
            @endforeach
        </div>

        {{-- STEP 1 --}}
        @if($step === 1)
        <form method="POST" action="{{ route('register.step1') }}" novalidate>
            @csrf
            <div class="bg-white rounded-3xl shadow-lg px-8 py-10">

                <h1 class="text-5xl font-black text-center mb-7 pb-2
                           bg-gradient-to-r from-brand-dark via-brand-purple to-brand-green
                           bg-clip-text text-transparent">
                    Sign Up
                </h1>

                @if($errors->any())
                <div class="mb-4 p-3 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-400 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div class="space-y-3">
                    <input type="text" name="name" value="{{ old('name', session('register_data.name')) }}"
                           placeholder="Full Name"
                           class="w-full bg-brand-light rounded-2xl px-5 py-3.5 text-sm text-brand-dark
                                  placeholder-brand-dark/35 outline-none border-2 border-transparent
                                  focus:border-brand-dark/25 transition-all @error('name') !border-red-300 @enderror">

                    <input type="text" name="username" value="{{ old('username', session('register_data.username')) }}"
                           placeholder="Username"
                           class="w-full bg-brand-light rounded-2xl px-5 py-3.5 text-sm text-brand-dark
                                  placeholder-brand-dark/35 outline-none border-2 border-transparent
                                  focus:border-brand-dark/25 transition-all @error('username') !border-red-300 @enderror">

                    <input type="email" name="email" value="{{ old('email', session('register_data.email')) }}"
                           placeholder="Email"
                           class="w-full bg-brand-light rounded-2xl px-5 py-3.5 text-sm text-brand-dark
                                  placeholder-brand-dark/35 outline-none border-2 border-transparent
                                  focus:border-brand-dark/25 transition-all @error('email') !border-red-300 @enderror">

                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <input type="password" name="password" id="inp-password"
                                   placeholder="Password"
                                   class="w-full bg-brand-light [&::-webkit-credentials-auto-fill-button]:hidden [&::-ms-reveal]:hidden [&::-ms-clear]:hidden rounded-2xl px-5 py-3.5 pr-12 text-sm text-brand-dark
                                          placeholder-brand-dark/35 outline-none border-2 border-transparent
                                          focus:border-brand-dark/25 transition-all @error('password') !border-red-300 @enderror">
                            <button type="button" onclick="togglePassword('inp-password','eye-password')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-dark/30 hover:text-brand-dark/60 transition-colors">
                                <svg id="eye-password" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="inp-password-confirm"
                                   placeholder="Confirm Password"
                                   class="w-full bg-brand-light rounded-2xl px-5 py-3.5 pr-12 text-sm text-brand-dark
                                          placeholder-brand-dark/35 outline-none border-2 border-transparent
                                          focus:border-brand-dark/25 transition-all">
                            <button type="button" onclick="togglePassword('inp-password-confirm','eye-password-confirm')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-dark/30 hover:text-brand-dark/60 transition-colors">
                                <svg id="eye-password-confirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['Male', 'Female'] as $option)
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="{{ $option }}" class="peer hidden"
                                   {{ old('gender', session('register_data.gender')) === $option ? 'checked' : '' }}>
                            <span class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl text-sm font-medium
                                         border-2 border-brand-dark/15 text-brand-dark/50
                                         peer-checked:border-brand-dark peer-checked:text-brand-dark peer-checked:bg-brand-light
                                         hover:border-brand-dark/30 transition-all duration-150 select-none">
                                {{ $option === 'Male' ? '👨' : '👩' }} {{ $option }}
                            </span>
                        </label>
                        @endforeach
                    </div>

                    <div>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-sm text-brand-dark/40 font-medium pointer-events-none select-none">+</span>
                            <input type="tel" name="phone_number" id="inp-phone"
                                   value="{{ old('phone_number', session('register_data.phone_number')) }}"
                                   placeholder="62xxxxxxxxxx"
                                   oninput="validatePhone(this)"
                                   class="w-full bg-brand-light rounded-2xl pl-8 pr-5 py-3.5 text-sm text-brand-dark
                                          placeholder-brand-dark/35 outline-none border-2 border-transparent
                                          focus:border-brand-dark/25 transition-all @error('phone_number') !border-red-300 @enderror">
                        </div>
                        <p id="phone-error" class="hidden text-xs text-red-400 mt-1.5 px-1">
                            Please use country code <strong>62</strong> instead of 0. Ex: <strong>6281234567890</strong>
                        </p>
                    </div>
                </div>

                <div class="flex justify-center mt-8">
                    <button type="submit"
                            class="px-14 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark font-bold text-sm
                                   hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                        Next
                    </button>
                </div>
            </div>
        </form>

        {{-- STEP 2 --}}
        @elseif($step === 2)
        <form method="POST" action="{{ route('register.step2') }}"
              enctype="multipart/form-data" novalidate>
            @csrf
            <div class="bg-white rounded-3xl shadow-lg px-8 py-10">

                @if($errors->any())
                <div class="mb-4 p-3 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-400 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div class="flex justify-center mb-8">
                    <label class="cursor-pointer">
                        <div id="photo-circle"
                             class="w-28 h-28 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden
                                    ring-2 ring-transparent hover:ring-brand-purple/40 transition-all">
                            @if(session('register_data.profile_photo'))
                                <img src="{{ Storage::url(session('register_data.profile_photo')) }}"
                                    alt="Profile Preview" class="w-full h-full object-cover">
                            @else
                                <div id="photo-placeholder">
                                    <svg class="w-10 h-10 text-brand-purple" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"/>
                                    </svg>
                                </div>
                                <img id="photo-preview" src="" alt="Preview" class="hidden w-full h-full object-cover">
                            @endif
                        </div>
                        <input type="file" name="profile_photo" id="photo-input"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               class="hidden" onchange="previewPhoto(this)">
                    </label>
                </div>

                <div class="space-y-3">
                    <textarea name="bio" placeholder="Short Bio — tell us about yourself and your skills..."
                              rows="3" maxlength="1000"
                              class="w-full bg-brand-light rounded-2xl px-5 py-3.5 text-sm text-brand-dark
                                     placeholder-brand-dark/35 outline-none border-2 border-transparent
                                     focus:border-brand-dark/20 transition-all resize-none
                                     @error('bio') border-red-300 @enderror">{{ old('bio', session('register_data.bio')) }}</textarea>

                    <label class="block cursor-pointer">
                        <div class="w-full bg-brand-light rounded-2xl px-5 py-3.5 flex items-center justify-between
                                    border-2 border-transparent hover:border-brand-dark/15 transition-all">
                            <span id="pdf-label" class="text-sm truncate flex-1 {{ session('register_data.portfolio_pdf') ? 'text-brand-green font-medium' : 'text-brand-dark/35' }}">
                                {{ session('register_data.portfolio_pdf')
                                            ? '✓ Portfolio already uploaded — upload new to replace'
                                            : 'Upload Portfolio (PDF)' }}
                            </span>
                            <svg class="w-4 h-4 text-brand-dark/30 shrink-0 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <input type="file" name="portfolio_pdf" accept="application/pdf"
                               class="hidden" onchange="onPdfChange(this)">
                    </label>
                </div>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('register.back', 1) }}"
                       class="px-8 py-2.5 rounded-full border-2 border-brand-dark/20 text-brand-dark/45 text-sm font-medium
                              hover:border-brand-dark/40 hover:text-brand-dark transition-all duration-200">
                        Back
                    </a>
                    <button type="submit"
                            class="px-8 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark font-bold text-sm
                                   hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                        Next
                    </button>
                </div>
            </div>
        </form>

        {{-- STEP 3 --}}
        @elseif($step === 3)
        <form method="POST" action="{{ route('register.step3') }}" novalidate>
            @csrf
            <div class="bg-white rounded-3xl shadow-xl shadow-brand-dark/10 px-8 py-10">

                <h1 class="text-5xl font-black text-center leading-tight mb-8
                           bg-gradient-to-b from-brand-dark to-brand-purple bg-clip-text text-transparent">
                    Set Up Your<br>Skills
                </h1>

                @if($errors->any())
                <div class="mb-4 p-3 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-400 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div class="space-y-5">
                    {{-- Your Skills --}}
                    <div>
                        <label class="block text-sm text-brand-dark/55 font-medium mb-2">Your Skills</label>
                        <div class="relative" id="your-skills-wrapper">
                            <div onclick="toggleSkillDropdown('your')"
                                 class="w-full bg-brand-light rounded-2xl px-4 py-3 flex items-center justify-between
                                        cursor-pointer border-2 border-transparent hover:border-brand-dark/15 transition-all min-h-[48px]">
                                <div id="your-tags" class="flex flex-wrap gap-1.5 flex-1">
                                    <span id="your-placeholder" class="text-sm text-brand-dark/35">Add skills you already have</span>
                                </div>
                                <span class="text-brand-dark/35 text-xs ml-2 shrink-0">▾</span>
                            </div>
                            <div id="your-dropdown"
                                 class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white rounded-2xl shadow-xl border border-brand-dark/8 z-30">
                                <div class="max-h-44 overflow-y-auto p-2">
                                    @foreach($skills as $skill)
                                    <div class="skill-item flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-brand-light cursor-pointer transition-colors"
                                         data-type="your" data-id="{{ $skill->id }}" data-name="{{ $skill->name }}"
                                         onclick="toggleSkill('your', {{ $skill->id }}, '{{ addslashes($skill->name) }}', this)">
                                        <span class="skill-check w-4 h-4 rounded-full border-2 border-brand-dark/20 flex items-center justify-center shrink-0 transition-all"></span>
                                        <span class="text-sm text-brand-dark">{{ $skill->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="your-inputs"></div>
                    </div>

                    {{-- Needed Skills --}}
                    <div>
                        <label class="block text-sm text-brand-dark/55 font-medium mb-2">Needed Skills</label>
                        <div class="relative" id="needed-skills-wrapper">
                            <div onclick="toggleSkillDropdown('needed')"
                                 class="w-full bg-brand-light rounded-2xl px-4 py-3 flex items-center justify-between
                                        cursor-pointer border-2 border-transparent hover:border-brand-dark/15 transition-all min-h-[48px]">
                                <div id="needed-tags" class="flex flex-wrap gap-1.5 flex-1">
                                    <span id="needed-placeholder" class="text-sm text-brand-dark/35">Add skills you need from others</span>
                                </div>
                                <span class="text-brand-dark/35 text-xs ml-2 shrink-0">▾</span>
                            </div>
                            <div id="needed-dropdown"
                                 class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white rounded-2xl shadow-xl border border-brand-dark/8 z-30">
                                <div class="max-h-44 overflow-y-auto p-2">
                                    @foreach($skills as $skill)
                                    <div class="skill-item flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-brand-light cursor-pointer transition-colors"
                                         data-type="needed" data-id="{{ $skill->id }}" data-name="{{ $skill->name }}"
                                         onclick="toggleSkill('needed', {{ $skill->id }}, '{{ addslashes($skill->name) }}', this)">
                                        <span class="skill-check w-4 h-4 rounded-full border-2 border-brand-dark/20 flex items-center justify-center shrink-0 transition-all"></span>
                                        <span class="text-sm text-brand-dark">{{ $skill->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="needed-inputs"></div>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('register.back', 2) }}"
                       class="px-8 py-2.5 rounded-full border-2 border-brand-dark/20 text-brand-dark/45 text-sm font-medium
                              hover:border-brand-dark/40 hover:text-brand-dark transition-all duration-200">
                        Back
                    </a>
                    <button type="submit"
                            class="px-8 py-2.5 rounded-full border-2 border-brand-dark text-brand-dark font-bold text-sm
                                   hover:bg-brand-dark hover:text-white active:scale-95 transition-all duration-200">
                        Register
                    </button>
                </div>
            </div>
        </form>
        @endif

        <p class="text-center text-sm text-brand-dark/45 mt-10">
            Already have an account?
            <a href="{{ route('login') }}" class="text-brand-purple font-semibold hover:underline underline-offset-2">Login</a>
        </p>

    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function validatePhone(input) {
        const err = document.getElementById('phone-error');
        const val = input.value.replace(/\D/g, '');
        input.value = val;
        err.classList.toggle('hidden', !val.startsWith('0'));
    }

    function previewPhoto(input) {
        if (!input.files?.[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photo-preview').src = e.target.result;
            document.getElementById('photo-preview').classList.remove('hidden');
            document.getElementById('photo-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }

    function onPdfChange(input) {
        const label = document.getElementById('pdf-label');
        label.textContent = input.files?.[0]?.name || 'Upload Portfolio (PDF)';
    }

    const selected = { your: new Set(), needed: new Set() };

    function toggleSkillDropdown(type) {
        const dd = document.getElementById(`${type}-dropdown`);
        dd.classList.toggle('hidden');
    }

    function toggleSkill(type, id, name, el) {
        const set  = selected[type];
        const check = el.querySelector('.skill-check');

        if (set.has(id)) {
            set.delete(id);
            check.innerHTML = '';
            check.classList.remove('bg-brand-purple', 'border-brand-purple', 'bg-brand-green', 'border-brand-green');
        } else {
            set.add(id);
            const color = type === 'your' ? 'brand-purple' : 'brand-green';
            check.classList.add(`bg-${color}`, `border-${color}`);
            check.innerHTML = `<svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>`;
        }
        renderTags(type);
        renderInputs(type);
    }

    function renderTags(type) {
        const container = document.getElementById(`${type}-tags`);
        const placeholder = document.getElementById(`${type}-placeholder`);
        const set = selected[type];
        const color = type === 'your' ? 'brand-purple' : 'brand-green';

        if (set.size === 0) {
            placeholder.classList.remove('hidden');
            container.querySelectorAll('.tag').forEach(t => t.remove());
            return;
        }
        placeholder.classList.add('hidden');
        container.querySelectorAll('.tag').forEach(t => t.remove());

        document.querySelectorAll(`#${type}-dropdown .skill-item`).forEach(item => {
            if (set.has(Number(item.dataset.id))) {
                const tag = document.createElement('span');
                tag.className = `tag text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-${color}/10 text-${color} border border-${color}/20`;
                tag.textContent = item.dataset.name;
                container.appendChild(tag);
            }
        });
    }

    function renderInputs(type) {
        const container = document.getElementById(`${type}-inputs`);
        const name = type === 'your' ? 'skills[]' : 'needed_skills[]';
        container.innerHTML = '';
        selected[type].forEach(id => {
            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = name;
            input.value = id;
            container.appendChild(input);
        });
    }

    document.addEventListener('click', e => {
        ['your', 'needed'].forEach(type => {
            const wrapper = document.getElementById(`${type}-skills-wrapper`);
            if (wrapper && !wrapper.contains(e.target)) {
                document.getElementById(`${type}-dropdown`)?.classList.add('hidden');
            }
        });
    });
</script>
@endpush
@endsection
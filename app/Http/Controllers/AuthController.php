<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('matchmaking.index'));
    }

    public function showRegister(): View
    {
        $step   = session('register_step', 1);
        $skills = Skill::orderBy('name')->get();

        return view('auth.register', compact('step', 'skills'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username', 'alpha_dash'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number'    => ['required', 'string', 'max:20'],
            'gender'   => ['required', 'in:Male,Female'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Please enter your name.',
            'name.string'   => 'Name must be valid text.',
            'name.max'      => 'Name cannot exceed 255 characters.',
            'username.required' => 'Please enter your username.',
            'username.string'   => 'Username must be valid text.',
            'username.max'      => 'Username cannot exceed 255 characters.',
            'username.unique'   => 'This username is already taken. Please try another.',
            'email.required' => 'Please enter your email address.',
            'email.string'   => 'Email must be valid text.',
            'email.email'    => 'Please enter a valid email address.',
            'email.max'      => 'Email cannot exceed 255 characters.',
            'email.unique'   => 'This email is already registered.',
            'gender.required' => 'Please select your gender.',
            'gender.in'       => 'Gender must be either Male or Female.',
            'password.required'  => 'Please enter a password.',
            'password.confirmed' => 'Password confirmation does not match.',
            'phone_number.required' => 'Please enter your phone number.',
            'phone_number.string' => 'Phone number must be valid text.',
            'phone_number.max'    => 'Phone number cannot exceed 20 characters.',
            'phone_number.regex'  => 'Phone number must start with country code 62. Ex: 6281234567890',
        ]);

        $existingData = session('register_data', []);

        session([
            'register_step' => 2,
            'register_data' => array_merge($existingData, [
                'name'     => $validated['name'],
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'phone_number'    => $validated['phone_number'],
                'gender'   => $validated['gender'],
                'password' => Hash::make($validated['password']),
            ]),
        ]);

        return redirect()->route('register');
    }

    public function storeStep2(Request $request): RedirectResponse
    {
        $alreadyHasPhoto = !empty(session('register_data.profile_photo'));
        $alreadyHasPdf   = !empty(session('register_data.portfolio_pdf'));
        $alreadyHasBio   = !empty(session('register_data.bio'));

        $request->validate([
            'bio' => [$alreadyHasBio ? 'nullable' : 'required', 'string', 'max:1000'],
            'profile_photo' => [$alreadyHasPhoto ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'portfolio_pdf' => [$alreadyHasPdf ? 'nullable' : 'required', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'bio.required' => 'Please tell us about yourself.',
            'bio.string'   => 'Your bio must be valid text.',
            'bio.max'      => 'Your bio can’t be longer than 1000 characters.',

            'profile_photo.required' => 'Please upload a profile photo.',
            'profile_photo.image'    => 'The file must be a valid image.',
            'profile_photo.mimes'    => 'Only JPG, JPEG, PNG, or WEBP formats are allowed.',
            'profile_photo.max'      => 'The profile photo must not exceed 2MB.',

            'portfolio_pdf.required' => 'Please upload your portfolio.',
            'portfolio_pdf.file'     => 'The portfolio must be a valid file.',
            'portfolio_pdf.mimes'    => 'Only PDF files are allowed.',
            'portfolio_pdf.max'      => 'The portfolio must not exceed 5MB.',
        ]);

        $registerData = session('register_data', []);
        $tempDir = 'temp/' . session()->getId();

        if ($request->hasFile('profile_photo')) {
            if (!empty($registerData['profile_photo'])) {
                Storage::disk('public')->delete($registerData['profile_photo']);
            }
            $registerData['profile_photo'] = $request->file('profile_photo')
                ->store($tempDir . '/profile-photos', 'public');
        }

        if ($request->hasFile('portfolio_pdf')) {
            if (!empty($registerData['portfolio_pdf'])) {
                Storage::disk('public')->delete($registerData['portfolio_pdf']);
            }
            $registerData['portfolio_pdf'] = $request->file('portfolio_pdf')
                ->store($tempDir . '/portfolios', 'public');
        }

        $registerData['bio'] = $request->input('bio');

        session([
            'register_step' => 3,
            'register_data' => $registerData,
        ]);

        return redirect()->route('register');
    }

    public function storeStep3(Request $request): RedirectResponse
    {
        $request->validate([
            'skills' => ['required', 'array', 'min:1'],
            'skills.*' => ['integer', 'exists:skills,id'],
            'needed_skills' => ['required', 'array', 'min:1'],
            'needed_skills.*' => ['integer', 'exists:skills,id'],
        ], [
            'skills.required' => 'Please select at least one skill.',
            'skills.array'    => 'Skills must be provided as a list.',
            'skills.min'      => 'Please select at least one skill.',
            'skills.*.integer' => 'Each selected skill must be valid.',
            'skills.*.exists' => 'One or more selected skills are invalid.',

            'needed_skills.required' => 'Please select at least one required skill.',
            'needed_skills.array'    => 'Required skills must be provided as a list.',
            'needed_skills.min'      => 'Please select at least one required skill.',
            'needed_skills.*.integer' => 'Each required skill must be valid.',
            'needed_skills.*.exists' => 'One or more required skills are invalid.',
        ]);

        $data = session('register_data', []);

        if (empty($data['email'])) {
            return redirect()->route('register')
                ->with('error', 'Your session has expired. Please start again.');
        }

        if (!empty($data['profile_photo'])) {
            $newPath = str_replace('temp/', '', $data['profile_photo']);
            Storage::disk('public')->move($data['profile_photo'], $newPath);
            $data['profile_photo'] = $newPath;
        }

        if (!empty($data['portfolio_pdf'])) {
            $newPath = str_replace('temp/', '', $data['portfolio_pdf']);
            Storage::disk('public')->move($data['portfolio_pdf'], $newPath);
            $data['portfolio_pdf'] = $newPath;
        }

        Storage::disk('public')->deleteDirectory('temp/' . session()->getId());

        $user = User::create([
            'name'              => $data['name'],
            'username'          => $data['username'],
            'email'             => $data['email'],
            'phone_number'      => $data['phone_number'],
            'gender'            => $data['gender'],
            'password'          => $data['password'],
            'bio'               => $data['bio'] ?? null,
            'profile_photo'     => $data['profile_photo'] ?? null,
            'portfolio_pdf'     => $data['portfolio_pdf'] ?? null,
            'email_verified_at' => now(),
        ]);

        if ($request->filled('skills')) {
            $user->skills()->sync($request->input('skills'));
        }
        if ($request->filled('needed_skills')) {
            $user->neededSkills()->sync($request->input('needed_skills'));
        }

        session()->forget(['register_step', 'register_data']);

        Auth::login($user);

        return redirect()->route('matchmaking.index')
            ->with('success', 'Welcome to SkillLab! 🎉');
    }

    public function backToStep(int $step): RedirectResponse
    {
        session(['register_step' => $step]);
        return redirect()->route('register');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

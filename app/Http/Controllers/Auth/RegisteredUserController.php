<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Log::info('Account creation attempt', ['email' => $request->email]);

        // Check if email exists in members table
        $member = Member::where('email', $request->email)->first();
        
        if (!$member) {
            // Guest trying to create account without member registration
            Log::info('Member not found, redirecting to member registration', ['email' => $request->email]);
            return back()
                ->withInput()
                ->with('error', 'You must register as a church member before creating an account.')
                ->with('show_member_registration', true);
        }
        
        Log::info('Member found', ['member_id' => $member->id, 'email' => $member->email]);
        
        // Check if member already has an account
        if ($member->user_id) {
            Log::info('Member already has linked account', ['member_id' => $member->id, 'user_id' => $member->user_id]);
            return back()
                ->withInput()
                ->with('error', 'This email is already registered. Please login instead.');
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'member',
            ]);

            Log::info('User created', ['user_id' => $user->id, 'email' => $user->email]);

            // Link to existing member
            $member->user_id = $user->id;
            $member->save();

            Log::info('User linked to member', ['user_id' => $user->id, 'member_id' => $member->id]);

            event(new Registered($user));

            Auth::login($user);
            
            DB::commit();

            Log::info('Account creation successful', ['user_id' => $user->id, 'member_id' => $member->id]);

            return redirect()->route('services')->with('success', 'Welcome! Your account is ready.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Account creation failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Account creation failed. Please try again.');
        }
    }
}

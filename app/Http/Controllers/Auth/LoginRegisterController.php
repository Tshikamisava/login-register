<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str; 
use Laravel\Socialite\Facades\Socialite; 
use Google_Client;

class LoginRegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Handle user authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($credentials)) {
            // Redirect back with errors if authentication fails
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect to the intended page or the dashboard
        return redirect()->intended('dashboard');
    }

    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard'); // Make sure 'dashboard.blade.php' exists in the 'resources/views' directory
        }

        return redirect()->route('login');
    }

    /**
     * Logout the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('login'); // or return response()->json(['message' => 'You have successfully logged out!']);
    }

    /**
     * Redirect to Google for authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($request->input('credential'));

            if ($payload) {
                $googleId = $payload['sub'];
                $email = $payload['email'];
                $name = $payload['name'];

                $user = User::where('email', $email)->first();

                if ($user) {
                    Auth::login($user);
                } else {
                    $user = User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make(Str::random(24)),
                        'google_id' => $googleId,
                    ]);
                    Auth::login($user);
                }

                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login')->withErrors(['msg' => 'Google login failed']);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Google login failed: ' . $e->getMessage()]);
        }
    }
}

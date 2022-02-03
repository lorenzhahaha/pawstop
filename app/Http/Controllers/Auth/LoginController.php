<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use PragmaRX\Google2FAQRCode\Google2FA;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Send the post-authentication response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return \Illuminate\Http\Response
     */
    private function authenticated(Request $request, $user)
    {
        if ($user->google2fa_secret) {
            Auth::logout();

            $request->session()->put('2fa:user:id', $user->id);

            return redirect()->route('otp-validate');
        }

        return redirect()->intended($this->redirectTo);
    }

    /**
     * Check either username or email.
     * @return string
     */
    public function username()
    {
        $identity = request()->get('username');
        $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function getValidateToken()
    {
        if (session('2fa:user:id')) {
            return view('validate-otp');
        }

        return redirect('login');
    }

    public function proceedValidateTokenThroughGoogle($id)
    {
        Session::put('2fa:user:id', $id);

        return redirect()->route('otp-validate');
    }

    /**
     *
     * @param  App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postValidateToken(Request $request)
    {
        $userId = $request->session()->pull('2fa:user:id');
        $user = User::find($userId);

        if ($user) {
            $google2fa = new Google2FA();

            $validator = Validator::make($request->all(), [
                'totp' => [
                    'bail',
                    'required',
                    'digits:6',
                    function ($attribute, $value, $fail) use ($google2fa, $user) {
                        $secret = Crypt::decrypt($user->google2fa_secret);
                        $result = $google2fa->verifyKey($secret, $value);

                        if (!$result) {
                            $fail('OTP is not valid.');
                        }
                    },
                ],
            ])->validate();

            //login and redirect user
            Auth::loginUsingId($user->id);

            return redirect()->intended($this->redirectTo);
        } else {
            return redirect()->back()->with('warning', 'User is invalid. Please try again.');
        }
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProviderLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProviderRegister()
    {
        Session::put('google-register', 'Google Registration Session');

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->withTrashed()->first();

        if ($existingUser) {
            if ($existingUser->deleted_at) {
                return redirect()->route('register')->with('warning', 'That account is blacklisted! Try again with different email.');
            } else {
                if ($existingUser->google2fa_secret) {
                    return $this->proceedValidateTokenThroughGoogle($existingUser->id);
                }

                auth()->login($existingUser, true);
            }
        } else {
            if (Session::has('google-register')) {
                // create a new user
                $newUser = new User;
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->google_id = $user->id;
                $newUser->avatar = $user->avatar;
                $newUser->avatar_original = $user->avatar_original;
                $newUser->save();
                auth()->login($newUser, true);

                Session::forget('google-register');
            } else {
                return redirect()->route('register')->with('warning', 'Your credentials does not exist in our records. Try signing up now!');
            }
        }
        return redirect()->route('home');
    }
}

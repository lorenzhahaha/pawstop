<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use ParagonIE\ConstantTime\Base32;
use PragmaRX\Google2FAQRCode\Google2FA;

class Google2FAController extends Controller
{
    use ValidatesRequests;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    public function security()
    {
        return view('security');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function securitySetup(Request $request)
    {
        //get user
        $user = $request->user();

        $secret = $this->generateSecret();

        $request->session()->flash('secret-otp', $secret);

        //generate image for QR barcode
        $google2fa = new Google2FA();
        $imageDataUri = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('security-setup', [
            'qr_code' => $imageDataUri,
            'secret' => $secret,
        ]);
    }

    public function securitySetupComplete(Request $request)
    {
        $google2fa = new Google2FA();
        $secret = Crypt::encrypt(session('secret-otp'));

        $validator = Validator::make($request->all(), [
            '2fa_verification_code' => [
                'bail',
                'required',
                'digits:6',
                function ($attribute, $value, $fail) use ($google2fa) {
                    $result = $google2fa->verifyKey(session('secret-otp'), $value);

                    if (!$result) {
                        $fail('OTP is not valid.');
                    }
                },
            ],
        ])->validate();

        Auth::user()->update([
            'google2fa_secret' => $secret,
        ]);

        return redirect()->route('security')->with('success', 'Security OTP has been activated successfully.');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function securityDeactivate(Request $request)
    {
        $user = $request->user();

        //make secret column blank
        $user->google2fa_secret = null;
        $user->save();

        return redirect()->route('security')->with('success', 'Security OTP has been deactivated successfully.');
    }

    /**
     * Generate a secret key in Base32 format
     *
     * @return string
     */
    private function generateSecret()
    {
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }
}

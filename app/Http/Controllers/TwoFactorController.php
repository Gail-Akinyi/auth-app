<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function show()
    {
        $user   = Auth::user();
        $qrCode = null;

        if (!$user->two_factor_enabled) {
            $secret = $this->google2fa->generateSecretKey();
            session(['2fa_secret' => $secret]);

            $qrCodeUrl = $this->google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secret
            );

            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCode = base64_encode($writer->writeString($qrCodeUrl));
        }

        return view('2fa.show', compact('qrCode'));
    }

    public function enable(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $secret = session('2fa_secret');
        $valid  = $this->google2fa->verifyKey($secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid code. Please try again.']);
        }

        Auth::user()->update([
            'two_factor_secret'  => $secret,
            'two_factor_enabled' => true,
        ]);

        session()->forget('2fa_secret');
        return back()->with('success', 'Two-factor authentication enabled!');
    }

    public function disable(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $valid = $this->google2fa->verifyKey(Auth::user()->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid code. Please try again.']);
        }

        Auth::user()->update([
            'two_factor_secret'  => null,
            'two_factor_enabled' => false,
        ]);

        return back()->with('success', 'Two-factor authentication disabled.');
    }

    public function showVerify()
    {
        return view('2fa.verify');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $user  = Auth::user();
        $valid = $this->google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid code. Please try again.']);
        }

        session(['2fa_verified' => true]);
        return redirect()->route('dashboard');
    }
}
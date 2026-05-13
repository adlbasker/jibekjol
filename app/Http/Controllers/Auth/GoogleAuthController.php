<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        return Socialite::driver('google')
            ->redirectUrl($this->redirectUrlForLocale($request->route('locale')))
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')
            ->redirectUrl($this->redirectUrlForLocale($request->route('locale')))
            ->stateless()
            ->user();

        $user = User::where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if (!$user) {
            $nameParts = preg_split('/\s+/', trim((string) $googleUser->name)) ?: [];
            $firstName = $nameParts[0] ?? 'Google';
            $lastName = $nameParts[1] ?? 'User';

            $region = Region::orderBy('id')->first();
            $regionId = $region->id ?? 0;
            $regionSlug = Str::upper(substr((string) ($region->slug ?? 'QAZ'), 0, 3));
            $tel = 'G'.substr(preg_replace('/\D/', '', (string) $googleUser->id), -14);
            $tel = str_pad($tel, 15, '0', STR_PAD_RIGHT);
            $idClient = 'J7788'.$regionSlug.substr($tel, -5);

            $user = User::create([
                'name' => $firstName,
                'lastname' => $lastName,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'tel' => $tel,
                'id_client' => Str::upper($idClient),
                'region_id' => $regionId,
                'address' => '',
                'password' => Hash::make(Str::random(40)),
            ]);
        } elseif (empty($user->google_id)) {
            $user->google_id = $googleUser->id;
            $user->save();
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended($request->route('locale').'/client');
    }

    private function redirectUrlForLocale(string $locale): string
    {
        return url($locale.'/auth/google/callback');
    }
}

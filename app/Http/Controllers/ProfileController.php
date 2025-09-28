<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Mengisi data name dan email
    $user->fill($request->validated());

    // Jika email diubah, reset verifikasi email
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // === LOGIKA UPLOAD FOTO PROFIL ===
    if ($request->hasFile('avatar')) {
        // Hapus foto lama jika ada
        if ($user->avatar && File::exists(public_path('avatars/' . $user->avatar))) {
            File::delete(public_path('avatars/' . $user->avatar));
        }

        // Upload foto baru
        $avatarName = time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('avatars'), $avatarName);
        $user->avatar = $avatarName;
    }
    // === AKHIR LOGIKA UPLOAD FOTO ===

    $user->save();

    return redirect()->route('dashboard')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

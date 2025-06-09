<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        $user->fill($request->validated());

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
                \Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    /**
     * Show the form for entering the user's name after registration.
     */
    public function showNameForm()
    {
        return view('auth.set-name');
    }

    /**
     * Store the user's name from the onboarding form.
     */
    public function storeName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        // Redirect to dashboard or home
        return redirect()->route('dashboard')->with('success', 'Name set successfully!');
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'current_theme_id' => 'required|exists:themes,id',
        ]);
        $user = $request->user();
        $user->current_theme_id = $request->current_theme_id;
        $user->save();
        return redirect()->back()->with('status', 'Theme updated!');
    }

    public function show($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $completedQuests = $user->tasks()->where('is_completed', true)->count();
        $achievements = $user->achievements;
        $currentStreak = $user->current_streak ?? 0;
        $longestStreak = $user->longest_streak ?? 0;
        return view('profile.show', compact('user', 'completedQuests', 'achievements', 'currentStreak', 'longestStreak'));
    }
}

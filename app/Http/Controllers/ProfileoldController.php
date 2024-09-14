<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the alumni information profile form.
     */
    public function editAlumniInformation(Request $request): View
    {
        $data = [
            'header' => 'Profile / Edit',
            'countries' => config('datasets.countries.list'),
            'nationalities' => config('datasets.nationalities.list'),
            'regions' => config('datasets.regions.list'),
            'provinces' => config('datasets.provinces.list'),
            'cities' => config('datasets.cities.list'),
            'barangays' => config('datasets.barangays.list'),
            'educationLevels' => config('datasets.education-levels.list'),
            'courses' => config('datasets.courses.list'),
            'departments' => config('datasets.departments.list'),
            'occupations' => config('datasets.occupations.list'),
            'genders' => config('datasets.genders.list'),
            'civilStatus' => config('datasets.civil-status.list'),
            'user' => $request->user(),
        ];

        return view('profile.edit', $data);
    }

    /**
     * Display the alumni information profile form.
     */
    public function editAdminInformation(Request $request): View
    {
        $data = [
            'header' => 'Profile / Edit',
            'user' => $request->user(),
        ];

        return view('profile.edit', $data);
    }

    /**
     * Display the user's details form.
     */
    public function details(Request $request): View
    {
        $data = [
            'header' => 'Profile',
            'user' => $request->user(),
            'profile' => Auth::user(),
        ];

        return view('profile.details', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {

        if ($request->image) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        }

        User::where('id', Auth::user()->id)->update([
            'username' => $request->username,
            'email' => $request->email,
            'image' => $imageName ?? null,
        ]);

        if ($request->image) {
            $request->image->storeAs('public/profile/images', $imageName);
        }

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
}

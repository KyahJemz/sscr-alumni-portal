<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();
        $information = $user->role === 'alumni' ? $user->alumniInformation : $user->adminInformation;
        $hobbies = $user->hobbies;

        $data = [
            'user' => $user,
            'information' => $information,
            'hobbies' => $hobbies,
        ];

        return view('profiles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        $data = [
            'user' => $user,
        ];

        return view('profiles.edit-user', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'username' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            ]);

            if ($request->image) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->storeAs('public/profile/images', $imageName);

                if ($user->image) {
                    Storage::delete('public/profile/images/' . $user->image);
                }
            } else {
                $imageName = $user->image;
            }

            $updatedFields = [];

            // if ($request->filled('username') && $user->username !== $request->input('username')) {
            //     $updatedFields['username'] = $request->input('username');
            // }

            if ($request->filled('email') && $user->email !== $request->input('email')) {
                $updatedFields['email'] = $request->input('email');
            }

            if ($request->has('image') && $user->image !== $imageName) {
                $updatedFields['image'] = $imageName;
            }

            if (!empty($updatedFields)) {
                $user->update($updatedFields);
                return back()->with('status', 'User profile updated successfully.');
            }

            return back()->with('status', 'No changes were made to the profile.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
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

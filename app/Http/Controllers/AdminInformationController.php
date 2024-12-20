<?php

namespace App\Http\Controllers;

use App\Models\AdminInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(AdminInformation $adminInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminInformation $adminInformation)
    {
        $user = Auth::user();
        $data = [
            'departments' => config('datasets.departments.list'),
            'user' => $user,
            'information' => $adminInformation,
        ];

        return view('profiles.edit-admin-information',$data );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminInformation $adminInformation)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:255',
            ]);

            $updatedFields = [];

            foreach ($request->all() as $key => $value) {
                if ($value !== null && $adminInformation->{$key} !== $value) {
                    if (isset($validEnums[$key]) && !in_array($value, $validEnums[$key])) {
                        continue;
                    }
                    $updatedFields[$key] = $value;
                }
            }

            if (!empty($updatedFields)) {
                $adminInformation->update($updatedFields);
                return redirect()->back()->with('success', 'Profile updated successfully.');
            }

            return redirect()->back()->with('info', 'No changes were made.');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminInformation $adminInformation)
    {
        //
    }
}

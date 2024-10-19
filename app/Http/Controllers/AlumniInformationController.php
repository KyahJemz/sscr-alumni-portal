<?php

namespace App\Http\Controllers;

use App\Models\AlumniInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AlumniInformationController extends Controller
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
    public function show(AlumniInformation $alumniInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlumniInformation $alumniInformation)
    {
        $user = Auth::user();
        $data = [
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
            'user' => $user,
            'information' => $alumniInformation,
        ];

        if($user->role !== 'cict_admin') {
            $data['user'] = User::find($alumniInformation->user_id);
        }

        return view('profiles.edit-alumni-information',$data );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlumniInformation $alumniInformation)
    {
        try {

            $validEnums = [
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
            ];

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:255',
                'nationality' => ['nullable', 'string', Rule::in($validEnums['nationalities'])],
                'civil_status' => ['nullable', 'string', Rule::in($validEnums['civilStatus'])],
                'age' => 'nullable|integer',
                'gender' => ['nullable', 'string', Rule::in($validEnums['genders'])],
                'street_address' => 'nullable|string',
                'country' => ['nullable', 'string', Rule::in($validEnums['countries'])],
                'region' => ['nullable', 'string', Rule::in($validEnums['regions'])],
                'province' => ['nullable', 'string', Rule::in($validEnums['provinces'])],
                'city' => ['nullable', 'string', Rule::in($validEnums['cities'])],
                'barangay' => ['nullable', 'string', Rule::in($validEnums['barangays'])],
                'postal_code' => 'nullable|string|max:255',
                'martial_status' => ['nullable', 'string', Rule::in($validEnums['departments'])],
                'education_level' => ['nullable', 'string', Rule::in($validEnums['educationLevels'])],
                'course' => ['required', 'string', Rule::in($validEnums['courses'])],
                'birth_date' => 'nullable|date',
                'batch' => 'required|string|max:255',
                'phone' => 'nullable|string|max:255',
                'occupation' => ['nullable', 'string', Rule::in($validEnums['occupations'])],
            ]);

            $updatedFields = [];

            foreach ($request->all() as $key => $value) {
                if ($value !== null && $alumniInformation->{$key} !== $value) {
                    if (isset($validEnums[$key]) && !in_array($value, $validEnums[$key])) {
                        continue;
                    }
                    $updatedFields[$key] = $value;
                }
            }

            if (!empty($updatedFields)) {
                $alumniInformation->update($updatedFields);
                return redirect()->back()->with('status', 'Information updated successfully.');
            }

            return redirect()->back()->with('status', 'No changes were made.')->withInput();

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlumniInformation $alumniInformation)
    {
        //
    }
}

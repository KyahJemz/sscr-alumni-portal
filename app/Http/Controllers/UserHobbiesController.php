<?php

namespace App\Http\Controllers;

use App\Models\Hobbies;
use App\Models\User;
use App\Models\UserHobbies;
use Illuminate\Http\Request;

class UserHobbiesController extends Controller
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
    public function show(UserHobbies $userHobbies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_id)
    {
        $userHobbies = UserHobbies::where('user_id', $user_id)->get();
        $hobbies = Hobbies::all();
        $user = User::find($user_id);


        $data = [
            'userHobbies' => $userHobbies,
            'hobbies' => $hobbies,
            'user' => $user,
        ];

        return view('profiles.edit-user-hobbies', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id)
    {

        try {
            // $request->validate([
            //     'hobbies_id.*' => 'required|integer|exists:hobbies,id',
            //     'user_hobby_ids.*' => 'required|integer|exists:user_hobbies,id',
            // ]);
            $hobbies_id = $request->hobbies_id ?? [];
            $user_hobby_ids = $request->user_hobby_ids ?? [];
            foreach ($hobbies_id as $updatedHobbies_id) {
                if (!in_array($updatedHobbies_id, $user_hobby_ids)) {
                    UserHobbies::create([
                        'user_id' => $user_id,
                        'hobbies_id' => $updatedHobbies_id,
                    ]);
                }
            }
            foreach ($user_hobby_ids as $oldUserHobbies_id) {
                if (!in_array($oldUserHobbies_id, $hobbies_id)) {
                    $userHobby = UserHobbies::where('user_id', $user_id)->where('hobbies_id', $oldUserHobbies_id)->first();
                    if ($userHobby) {
                        $userHobby->deleted_by = $user_id;
                        $userHobby->save();
                        $userHobby->delete();
                    }
                }
            }
            return back();

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserHobbies $userHobbies)
    {
        //
    }
}

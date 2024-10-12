<?php

namespace App\Http\Controllers;

use App\Models\GroupHobbies;
use Illuminate\Http\Request;

class GroupHobbiesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'group_id' => 'required|string',
            'hobby_id' => 'required|string',
        ]);

        try {
            GroupHobbies::create([
                'group_id' => $request->group_id,
                'hobbies_id' => $request->hobby_id,
            ]);
            return response()->json([
                'message' => 'Group hobby added successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apiDestroy(Request $request)
    {
        $request->validate([
            'group_id' => 'required|string',
            'hobby_id' => 'required|string',
        ]);

        try {
            GroupHobbies::where('group_id', $request->group_id)->where('hobbies_id', $request->hobby_id)->delete();
            return response()->json([
                'message' => 'Group hobby deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}

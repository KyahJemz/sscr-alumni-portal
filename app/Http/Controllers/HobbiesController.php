<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Hobbies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HobbiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'groups' => Group::whereNull('deleted_at')->get(),
        ];
        return view('hobbies.index', $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function apiIndex()
    {
        $data = [
            'hobbies' => Hobbies::with('groups')->whereNull('deleted_at')->get(),
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        try {
            Hobbies::create([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
            ]);

            return response()->json([
                'message' => 'Hobby created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function apiUpdate(Request $request, Hobbies $hobbies)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        try {
            $hobbies->update([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
            ]);
            $hobbies->save();

            return response()->json([
                'message' => 'Hobby updated successfully',
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
    public function apiDestroy(Hobbies $hobbies)
    {
        $hobbies->update(['deleted_at' => Carbon::now('Asia/Manila'), 'deleted_by' => Auth::user()->id]);
        $hobbies->save();
        $hobbies->delete();

        return response()->json([
            'message' => 'Hobby deleted successfully',
        ]);
    }
}

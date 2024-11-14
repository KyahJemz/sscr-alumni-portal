<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupAdmin;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupLeaveController extends Controller
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        try {
            $groupAdmin = GroupAdmin::where('group_id', $group->id)->where('user_id', Auth::user()->id)->whereNull('deleted_at')->latest()->first();
            if ($groupAdmin) {
                $groupAdmin->delete();
            }
            $groupMember = GroupMember::where('group_id', $group->id)->where('user_id', Auth::user()->id)->whereNull('deleted_at')->latest()->first();
            if ($groupMember) {
                $groupMember->delete();
            }
            return redirect()->back()->with('status', 'Successfully left group');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to leave group: ' . $e->getMessage());
        }
    }
}

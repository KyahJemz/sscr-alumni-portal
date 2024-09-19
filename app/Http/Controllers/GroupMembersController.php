<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupMembersController extends Controller
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
        try {
            $user = Auth::user();

            $request->validate([
                'group_id' => 'required|exists:groups,id'
            ]);

            $existingMember = GroupMember::where('user_id', $user->id)
                ->where('group_id', $request->group_id)
                ->latest()
                ->first();
            if ($existingMember && !is_null($existingMember->approved_at)) {
                return redirect()->back()->with('status', 'You are already a member of this group.');
            }

            GroupMember::create([
                'user_id' => $user->id,
                'group_id' => $request->group_id
            ]);

            return redirect()->back()->with('status', 'Successfully joined group');
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(GroupMember $groupMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GroupMember $groupMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GroupMember $groupMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupMember $groupMember)
    {
        $user = Auth::user();

        if ($groupMember->user_id !== $user->id && !$user->groupsManaged->contains($groupMember->group_id)) {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        try {
            $groupMember->delete();
            return redirect()->back()->with('status', 'Successfully left group');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to leave group: ' . $e->getMessage());
        }
    }
}

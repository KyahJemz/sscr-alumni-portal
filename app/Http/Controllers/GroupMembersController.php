<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
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
    public function apiShow(Group $group)
    {
        $members = $group->group_members()
            ->whereNull('deleted_at')
            ->whereNull('rejected_at')
            ->whereNotNull('approved_at')
            ->orderBy('created_at', 'desc')
            ->with(['user.alumniInformation', 'user.adminInformation'])
            ->get();

        $members_Approval = $group->group_members()
            ->whereNull('deleted_at')
            ->whereNull('rejected_at')
            ->whereNull('approved_at')
            ->orderBy('created_at', 'desc')
            ->with(['user.alumniInformation', 'user.adminInformation'])
            ->get();

        $admins = $group->group_admins()
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->with(['user.alumniInformation', 'user.adminInformation'])
            ->get();

        $data = [
            'members_list' => $members,
            'members_approval_list' => $members_Approval,
            'admins_list' => $admins
        ];

        return response()->json($data);
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
    public function apiUpdate(Request $request, GroupMember $groupMember)
    {

        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        try {

            if ($request->status === 'approved') {
                $groupMember->update([
                    'approved_at' => now(),
                    'approved_by' => Auth::user()->id
                ]);
            } else {
                $groupMember->update([
                    'rejected_at' => now(),
                    'rejected_by' => Auth::user()->id
                ]);
            }
            $groupMember->save();

            return response()->json(['status' => 'success', 'message' => 'Successfully updated']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to update group member: ' . $e->getMessage()]);
        }

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

    public function apiDestroy(Group $group, User $user)
    {
        try {
            $groupMember = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->whereNull('deleted_at')->latest()->first();
            $groupMember->delete();
            return response()->json(['status' => 'success', 'message' => 'Successfully removed from the group']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to remove from the group: ' . $e->getMessage()]);
        }
    }
}

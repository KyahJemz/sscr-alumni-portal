<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupAdmin;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupAdminsController extends Controller
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
    public function store(Group $group, Request $request)
    {
        $request->validate([
            'admin_ids' => 'required|string',
        ]);

        $proposedAdmins = json_decode($request->admin_ids);

        if (!is_array($proposedAdmins)) {
            return redirect()->back()->withErrors('Invalid admin list format.');
        }
        try {

            foreach ($proposedAdmins as $adminId) {
                GroupAdmin::create([
                    'group_id' => $group->id,
                    'user_id' => $adminId,
                    'created_by' => Auth::user()->id
                ]);
                Notification::create([
                    'type' => 'group',
                    'user_id' => $adminId,
                    'content' => "You have been added as a group admin in " . $group->name,
                    'url' => "/groups/{$group->id}",
                ]);
            }

            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Error creating group: ', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Failed to create the group. Please try again.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function apiShow(Group $group)
    {
        // $members = $group->group_members()
        //     ->whereNull('deleted_at')
        //     ->whereNull('rejected_at')
        //     ->whereNotNull('approved_at')
        //     ->orderBy('created_at', 'desc')
        //     ->with(['user.alumniInformation', 'user.adminInformation'])
        //     ->get();

        // $members_Approval = $group->group_members()
        //     ->whereNull('deleted_at')
        //     ->whereNull('rejected_at')
        //     ->whereNull('approved_at')
        //     ->orderBy('created_at', 'desc')
        //     ->with(['user.alumniInformation', 'user.adminInformation'])
        //     ->get();

        // $admins = $group->group_admins()
        //     ->whereNull('deleted_at')
        //     ->orderBy('created_at', 'desc')
        //     ->with(['user.alumniInformation', 'user.adminInformation'])
        //     ->get();

        // $data = [
        //     'members_list' => $members,
        //     'members_approval_list' => $members_Approval,
        //     'admins_list' => $admins

        // ];
        // return response()->json($data);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GroupAdmin $groupMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GroupAdmin $groupMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apiDestroy(Group $group, User $user)
    {
        try {
            $groupAdmin = GroupAdmin::where('group_id', $group->id)->where('user_id', $user->id)->whereNull('deleted_at')->latest()->first();
            $groupAdmin->delete();
            Notification::create([
                'type' => 'group',
                'user_id' => $user->id,
                'content' => "You have been removed as a group admin in " . $group->name,
                'url' => "/groups/{$group->id}",
            ]);
            return response()->json(['status' => 'success', 'message' => 'Successfully removed from the group']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to remove from the group: ' . $e->getMessage()]);
        }
    }
}

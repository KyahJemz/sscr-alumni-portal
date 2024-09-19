<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        $myGroups = Auth::user()->groups;
        $recommended = $groups->diff($myGroups);
        $user = Auth::user();
        $data = [
            'groups' => $groups,
            'myGroups' => $myGroups,
            'recommended' => $recommended,
            'user' => $user
        ];
        return view('groups.index', $data);
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
    public function show(Group $group)
    {
        $user = Auth::user();
        $groupManaged = $user->groupsManaged;
        $isAdmin = $groupManaged->contains($group);

        $groupMembers = GroupMember::where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->whereNull('deleted_at')
            ->latest()
            ->first();
        if ($groupMembers && !is_null($groupMembers->approved_at)) {
            $status = 'member';
        } elseif ($groupMembers && is_null($groupMembers->rejected_at) && is_null($groupMembers->approved_at)) {
            $status = 'pending';
        } else {
            $status = 'not a member';
        }

        $data = [
            'group' => $group,
            'status' => $status, // member, not a member, pending
            'isAdmin' => $isAdmin,
            'groupMember' => $groupMembers,
            'user' => $user
        ];

        return view('groups.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {

    }
}

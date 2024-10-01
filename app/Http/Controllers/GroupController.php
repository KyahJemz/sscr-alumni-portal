<?php

namespace App\Http\Controllers;

use App\Models\AlumniInformation;
use App\Models\Group;
use App\Models\GroupAdmin;
use App\Models\GroupMember;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Js;

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
        if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator') {
            $data['alumni_list'] = User::where('role', 'alumni')
                ->whereNull('deleted_at')
                ->whereNotNull('approved_at')
                ->whereHas('alumniInformation')
                ->with('alumniInformation')
                ->get()->all();
        }

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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'admin_ids' => 'required|string',
        ]);

            $proposedAdmins = json_decode($request->admin_ids);

            if (!is_array($proposedAdmins)) {
                return redirect()->back()->withErrors('Invalid admin list format.');
            }

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = 't_' . $originalName . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('public/groups/images', $imageName);
        }

        DB::beginTransaction();

        try {

            $group = Group::create([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
                'image' => $imageName,
            ]);


            foreach ($proposedAdmins as $adminId) {
                GroupAdmin::create([
                    'group_id' => $group->id,
                    'user_id' => $adminId,
                    'created_by' => Auth::user()->id
                ]);
            }

            DB::commit();

            return redirect()->route('groups.show', $group->id);

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            Log::error('Error creating group: ', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Failed to create the group. Please try again.');
        }
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

        $group_data = [
            'members' => GroupMember::where('group_id', $group->id)->whereNull('deleted_at')->whereNull('rejected_at')->whereNotNull('approved_at')->with(['user.alumniInformation', 'user.adminInformation'])->orderBy('created_at', 'desc')->get(),
            'posts' => Post::where('group_id', $group->id)->whereNull('deleted_at')->whereNull('rejected_at')->whereNotNull('approved_at')->get(),
            'events' => Post::where('group_id', $group->id)->whereNull('deleted_at')->whereNull('rejected_at')->whereNotNull('approved_at')->whereHas('event')->get(),
            'admins' => GroupAdmin::where('group_id', $group->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->get(),
        ];

        $data = [
            'group' => $group,
            'status' => $status, // member, not a member, pending
            'isAdmin' => $isAdmin,
            'groupMember' => $groupMembers,
            'user' => $user,
            'group_data' => $group_data,
        ];

        return view('groups.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
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

        $group_data = [
            'members' => GroupMember::where('group_id', $group->id)->whereNull('deleted_at')->whereNull('rejected_at')->whereNotNull('approved_at')->with(['user.alumniInformation', 'user.adminInformation'])->orderBy('created_at', 'desc')->get(),
            'posts' => Post::where('group_id', $group->id)->whereNull('deleted_at')->whereNull('rejected_at')->whereNotNull('approved_at')->get(),
            'events' => Post::where('group_id', $group->id)->whereNull('deleted_at')->whereNull('rejected_at')->whereNotNull('approved_at')->whereHas('event')->get(),
            'admins' => GroupAdmin::where('group_id', $group->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->get(),
        ];

        $data = [
            'group' => $group,
            'status' => $status, // member, not a member, pending
            'isAdmin' => $isAdmin,
            'groupMember' => $groupMembers,
            'user' => $user,
            'group_data' => $group_data,
            'batches' => AlumniInformation::distinct('batch')->orderBy('batch', 'desc')->get(['batch']),
            'courses' => AlumniInformation::distinct('course')->orderBy('course', 'desc')->get(['course']),
        ];

        if (Auth::user()->role === 'cict_admin' || Auth::user()->role === 'alumni_coordinator') {
            $data['alumni_list'] = User::where('role', 'alumni')
                ->whereNull('deleted_at')
                ->whereNotNull('approved_at')
                ->whereHas('alumniInformation')
                ->with('alumniInformation')
                ->get()->all();
        }

        return view('groups.manage.index', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function apiUpdate(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = 't_' . $originalName . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('public/groups/images', $imageName);
        }

    try {

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName ?? $group->image,
        ]);
        $group->save();

        return redirect()->back()->with('status', 'group-updated');

    } catch (\Exception $e) {
        dd($e);
        Log::error('Error creating group: ', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors('Failed to update group.');
    }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {

    }
}

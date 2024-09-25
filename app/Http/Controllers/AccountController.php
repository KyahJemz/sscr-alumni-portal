<?php

namespace App\Http\Controllers;

use App\Models\AdminInformation;
use App\Models\AlumniInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'alumni_list' => User::with(['alumniInformation'])->whereNull('deleted_at')->where('role', 'alumni')->get()->all(),
            'admin_list' => User::with(['adminInformation'])->whereNull('deleted_at')->whereNot('role', 'alumni')->get()->all(),
        ];

        return view('accounts.index', $data);
    }

    public function apiIndex()
    {
        $data = [
            'alumni_list' => User::with(['alumniInformation'])->whereNull('deleted_at')->where('role', 'alumni')->get()->all(),
            'admin_list' => User::with(['adminInformation'])->whereNull('deleted_at')->whereNot('role', 'alumni')->get()->all(),
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function apiStore(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|unique:users,email',
            'alumni_id' => 'required|unique:users,username',
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
        ]);

        DB::beginTransaction();

        if (Auth::user()->role !== 'alumni') {
            if (Auth::user()->role === 'program_chair') {
                $user = User::create([
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => 'alumni',
                    'username' => $request->alumni_id,
                    'username' => $request->alumni_id,
                    'created_by' => Auth::user()->id,
                ]);

                AlumniInformation::create([
                    'user_id' => $user->id,
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'suffix' => $request->suffix,
                    'course' => $request->course,
                    'batch' => $request->batch,
                ]);
            } else {
                if ($request->role === 'alumni') {
                    $user = User::create([
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'role' => 'alumni',
                        'username' => $request->alumni_id,
                        'created_by' => Auth::user()->id,
                        'approved_by' => Auth::user()->id,
                        'approved_at' => Carbon::now(),
                    ]);

                    AlumniInformation::create([
                        'user_id' => $user->id,
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'last_name' => $request->last_name,
                        'suffix' => $request->suffix,
                        'course' => $request->course,
                        'batch' => $request->batch,
                    ]);
                } else {
                    $user = User::create([
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'role' => 'admin',
                        'username' => $request->alumni_id,
                        'created_by' => Auth::user()->id,
                        'approved_by' => Auth::user()->id,
                        'approved_at' => Carbon::now(),
                    ]);

                    AdminInformation::create([
                        'user_id' => $user->id,
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'last_name' => $request->last_name,
                        'suffix' => $request->suffix,
                        'department' => $request->department,
                    ]);
                }
            }
        }

        DB::commit();
        return response()->json(['message' => 'User created successfully'], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('User creation failed: ' . $e->getMessage());
        return response()->json(['message' => 'User creation failed', 'error' => $e->getMessage()], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function apiApproval(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required',
        ]);
        if(Auth::user()->role !== 'alumni' && Auth::user()->role !== 'program_chair') {
            if($request->status === 'approve') {
                $user->update([
                    'approved_by' => Auth::user()->id,
                    'approved_at' => Carbon::now(),
                ]);
                $user->save();
            } else if($request->status === 'reject') {
                $user->update([
                    'rejected_by' => Auth::user()->id,
                    'rejected_at' => Carbon::now(),
                ]);
                $user->save();
            } else {
                return response()->json(['message' => 'Invalid status update'], 500);
            }
            return response()->json(['message' => 'Account status updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid role'], 500);
        }
    }

    public function apiActivation(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required',
        ]);
        if(Auth::user()->role !== 'alumni' && Auth::user()->role !== 'program_chair') {
            if($request->status === 'activate') {
                $user->update([
                    'disabled_at' => null,
                    'disabled_by' => null,
                ]);
                $user->save();
            } else if($request->status === 'deactivate') {
                $user->update([
                    'disabled_at' => Carbon::now(),
                    'disabled_by' => Auth::user()->id,
                ]);
                $user->save();
            } else {
                return response()->json(['message' => 'Invalid status update'], 500);
            }

            return response()->json(['message' => 'Account status updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid role'], 500);
        }
    }

    public function apiDestroy(Request $request, User $user)
    {
        if(Auth::user()->role !== 'alumni' && Auth::user()->role !== 'program_chair') {
            $user->update([
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id,
            ]);
            $user->save();

            return response()->json(['message' => 'Account deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid role'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function apiUpdate(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

}

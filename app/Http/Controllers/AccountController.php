<?php

namespace App\Http\Controllers;

use App\Excel\Exports\CustomExport;
use App\Models\AdminInformation;
use App\Models\AlumniInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Excel\Imports\CustomImport;

class AccountController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'headers' => 'required|array'
        ]);

        $data = $request->data ? $request->input('data') : [];
        $headers = $request->input('headers');

        return Excel::download(new CustomExport($data, $headers), 'export-' . Carbon::now('Asia/Manila')->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function apiImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $data = Excel::toArray(new CustomImport, $request->file('file'));

        $sheetData = $data[0];

        $sheetData = array_slice($sheetData, 1);

        $failedToUpload = [];

        $alumniTotalCount = User::where('role', 'alumni')->withTrashed()->count();

        foreach ($sheetData as $row) {
            if (count($row) < 7) {
                $failedToUpload[] = "Invalid row length: " . $row;
                continue;
            }
            if (empty($row[6]) || empty($row[7]) || empty($row[5]) || empty($row[1]) || empty($row[2])) {
                $failedToUpload[] = "Missing column data: " . $row;
                continue;
            }
            $isExist = User::where('email', $row[5])->first();
            if($isExist) {
                $failedToUpload[] = "Email already exists: " . $row[5];
                continue;
            }

            try {
                $alumniTotalCount++;
                $formattedUsername = sprintf('%s-%07d', $row[6], $alumniTotalCount);

                // first 2 letters of first name, last 2 letters of last name, and batch)
                $defaultPassword = strtoupper(substr($row[1], 0, 2)) . strtoupper(substr($row[2], -2)) . $row[5];

                $user = User::create([
                    'created_by' => Auth::user()->id,
                    'username' => $formattedUsername,
                    'role' => 'alumni',
                    'approved_by' => null,
                    'approved_at' => null,
                    'rejected_by' => null,
                    'rejected_at' => null,
                    'email' => $row[5],
                    'password' => bcrypt($defaultPassword),
                ]);

                AlumniInformation::create([
                    'user_id' => $user->id,
                    'first_name' => $row[1],
                    'last_name' => $row[2],
                    'middle_name' => $row[3] ?? null,
                    'suffix' => $row[4] ?? null,
                    'batch' => $row[6],
                    'course' => $row[7],
                ]);
            } catch (\Exception $e) {
                $failedToUpload[] = $e->getMessage() . ": " . $row;
                continue;
            }
        }

        return response()->json([
            'message' => 'File uploaded and data processed successfully',
            'failed' => $failedToUpload,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        switch ($type) {
            case 'alumni':
                if (Auth::user()->role != 'alumni') {
                    $data = [
                        'batches' => AlumniInformation::distinct('batch')->orderBy('batch', 'desc')->get(['batch']),
                        'courses' => AlumniInformation::distinct('course')->orderBy('course', 'desc')->get(['course']),
                    ];
                    return view('accounts.alumni.index', $data);
                } else {
                    return abort(401, 'Unauthorized');
                }
                break;
            case 'admins':
                if (Auth::user()->role === 'cict_admin') {
                    return view('accounts.admin.index');
                } else {
                    return abort(401, 'Unauthorized');
                }
                break;
            case 'graduates':
                if (Auth::user()->role != 'alumni') {
                    $data = [
                        'batches' => AlumniInformation::distinct('batch')->orderBy('batch', 'desc')->get(['batch']),
                        'courses' => AlumniInformation::distinct('course')->orderBy('course', 'desc')->get(['course']),
                    ];
                    return view('accounts.graduates.index',$data);
                } else {
                    return abort(401, 'Unauthorized');
                }
                break;
            default:
                return abort(403, 'Forbidden');
                break;
        }
    }

    public function apiIndex($type)
    {
        $data = [];
        switch ($type) {
            case 'alumni':
                if (Auth::user()->role != 'alumni') {
                    $data = [
                        'alumni_list' => User::with(['alumniInformation'])->whereNull('deleted_at')->where('role', 'alumni')->whereNotNull('approved_at')->whereNull('rejected_at')->get(),
                    ];
                } else {
                    return abort(401, 'Unauthorized');
                }
                break;
            case 'admins':
                if (Auth::user()->role === 'cict_admin') {
                    $data = [
                        'admin_list' => User::with(['adminInformation'])->whereNull('deleted_at')->whereNot('role', 'alumni')->get(),
                    ];
                } else {
                    return abort(401, 'Unauthorized');
                }
                break;
            case 'graduates':
                if (Auth::user()->role != 'alumni') {
                    $data = [
                        'alumni_list' => User::with(['alumniInformation'])->whereNull('deleted_at')->where('role', 'alumni')->whereNull('approved_at')->whereNull('rejected_at')->get(),
                    ];
                } else {
                    return abort(401, 'Unauthorized');
                }
                break;
            default:
                return abort(403, 'Forbidden');
                break;
        }
        $data['user'] = Auth::user();
        return response()->json($data);
        dd($data);
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
                'first_name' => 'required',
                'last_name' => 'required',
                'role' => 'required',
            ]);

            DB::beginTransaction();

            if (Auth::user()->role !== 'alumni') {
                if (Auth::user()->role === 'program_chair') {
                    $request->validate([
                        'course' => 'required',
                        'batch' => 'required',
                    ]);
                    $alumniTotalCount = User::where('role', 'alumni')->withTrashed()->count();
                    $defaultPassword = strtoupper(substr($request->first_name, 0, 2)) . strtoupper(substr($request->last_name, -2)) . $request->batch;
                    $formattedUsername = sprintf('%s-%07d', $request->batch, $alumniTotalCount++);
                    $user = User::create([
                        'email' => $request->email,
                        'password' => bcrypt($defaultPassword),
                        'role' => 'alumni',
                        'username' => $formattedUsername,
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
                        $request->validate([
                            'course' => 'required',
                            'batch' => 'required',
                        ]);
                        // first 2 letters of first name, last 2 letters of last name, and batch)
                        $alumniTotalCount = User::where('role', 'alumni')->withTrashed()->count();
                        $defaultPassword = strtoupper(substr($request->first_name, 0, 2)) . strtoupper(substr($request->last_name, -2)) . $request->batch;
                        $formattedUsername = sprintf('%s-%07d', $request->batch, $alumniTotalCount++);
                        if ($request->approved === 'yes') {
                            $user = User::create([
                                'email' => $request->email,
                                'password' => bcrypt($defaultPassword),
                                'role' => 'alumni',
                                'username' => $formattedUsername,
                                'created_by' => Auth::user()->id,
                                'approved_by' => Auth::user()->id,
                                'approved_at' => Carbon::now('Asia/Manila'),
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
                            $details = [
                                'title' => 'Welcome Aboard: Access Your SSCR Alumni Portal Now!',
                                'alumni_id' => $user->username,
                                'name' => $request->first_name . ' ' . $request->last_name,
                            ];
                            \Mail::to($user->email)->send(new \App\Mail\AccountApproved($details));
                        } else {
                            $user = User::create([
                                'email' => $request->email,
                                'password' => bcrypt($defaultPassword),
                                'role' => 'alumni',
                                'username' => $formattedUsername,
                                'created_by' => Auth::user()->id,
                                'approved_by' => null,
                                'approved_at' => null,
                            ]);

                            $test = AlumniInformation::create([
                                'user_id' => $user->id,
                                'first_name' => $request->first_name,
                                'middle_name' => $request->middle_name,
                                'last_name' => $request->last_name,
                                'suffix' => $request->suffix,
                                'course' => $request->course,
                                'batch' => $request->batch,
                            ]);
                        }
                    } else {
                        $user = User::create([
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'role' => $request->role,
                            'username' => $request->email,
                            'created_by' => Auth::user()->id,
                            'approved_by' => Auth::user()->id,
                            'approved_at' => Carbon::now('Asia/Manila'),
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
                    'approved_at' => Carbon::now('Asia/Manila'),
                ]);
                $user->save();
                $details = [
                    'title' => 'Welcome Aboard: Access Your SSCR Alumni Portal Now!',
                    'alumni_id' => $user->username,
                    'name' => $user->alumniInformation->first_name . ' ' . $user->alumniInformation->last_name,
                ];
                \Mail::to($user->email)->send(new \App\Mail\AccountApproved($details));
            } else if($request->status === 'reject') {
                $user->update([
                    'rejected_by' => Auth::user()->id,
                    'rejected_at' => Carbon::now('Asia/Manila'),
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
                    'disabled_at' => Carbon::now('Asia/Manila'),
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
        if(Auth::user()->role !== 'alumni') {
            $user->update([
                'deleted_at' => Carbon::now('Asia/Manila'),
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

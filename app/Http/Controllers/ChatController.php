<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        $user = Auth::user();

        $messages = Chat::where(function ($query) use ($user, $id) {
            $query->where('sent_by', $user->id)
                ->where('received_by', $id);
        })->orWhere(function ($query) use ($user, $id) {
            $query->where('sent_by', $id)
                ->where('received_by', $user->id);
        })->orderBy('created_at', 'asc')->get();

        return $messages;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $data = [
            'alumni_id' => 'alumni_id',
            'name' => 'name',
            'title' => 'title',
        ];
        return view('mail.account-approved', ['data' => $data]);
    }
}

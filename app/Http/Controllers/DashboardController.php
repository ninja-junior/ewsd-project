<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $department= Auth::user()->department;
                // dd($department);
        
        return view('dashboard.index',['department'=>$department]);
    }

    public function create()
    {
        $department= Auth::user()->department;
        return view('dashboard.create',['department'=>$department]);
    }

    public function update(Post $post)
    {
        return view('dashboard.update',compact('post'));
    }
}

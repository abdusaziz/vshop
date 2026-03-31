<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard',[
            'admin' => 'Props Admin Dashboard',
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
        ]);
    }
}

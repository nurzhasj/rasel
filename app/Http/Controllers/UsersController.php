<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->with('orders')
            ->where('id', '!=', 1)
            ->get();

        return view('users', compact('users'));
    }
}

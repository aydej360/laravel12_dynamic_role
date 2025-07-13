<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        Log::info('Dashboard accessed by: ' . auth()->user()->name);

        return view('dashboard', compact('stats'));
    }
}

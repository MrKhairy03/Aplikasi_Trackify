<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    /**
     * Menampilkan data aktivitas (read-only)
     */
    public function index(Request $request)
    {
        $activities = Activities::with('user')
            ->latest('created_at')
            ->get();

        return view('environments.activities.content', compact('activities'));
    }
}

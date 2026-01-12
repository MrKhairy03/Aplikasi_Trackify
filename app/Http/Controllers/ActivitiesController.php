<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        $activities = Activities::with('user')
            ->latest('created_at')
            ->get();

        return view('environments.activities.content', compact('activities'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (
            $request->filled('from') ||
            $request->filled('to') ||
            $request->filled('action')
        ) {
            ActivityLogger::log('filter_dashboard');
        }

        $from   = $request->input('from', now()->subDays(7)->startOfDay());
        $to = $request->filled('to') ? Carbon::parse($request->to)->endOfDay() : now()->endOfDay();
        $action = $request->input('action');

        $baseQuery = Activities::whereBetween('activities.created_at', [$from, $to]);

        if (!empty($action)) {
            $baseQuery->where('activities.action', $action);
        }

        $totalActivities = (clone $baseQuery)->count();

        $totalActiveUsers = (clone $baseQuery)
            ->distinct('activities.user_id')
            ->count('activities.user_id');

        $totalActions = (clone $baseQuery)
            ->distinct('activities.action')
            ->count('activities.action');

        $topUserActivities = (clone $baseQuery)
            ->select('activities.user_id', DB::raw('COUNT(*) as total'))
            ->groupBy('activities.user_id')
            ->orderByDesc('total')
            ->limit(1)
            ->value('total');

        $actions = Activities::select('action')->distinct()->pluck('action');

        $activityPerDay = (clone $baseQuery)
            ->select(
                DB::raw('DATE(activities.created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('DATE(activities.created_at)'))
            ->orderBy('date')
            ->get();

        $topUsers = (clone $baseQuery)
            ->join('users', 'users.id', '=', 'activities.user_id')
            ->select(
                'users.name',
                DB::raw('COUNT(activities.id) as total')
            )
            ->groupBy('users.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topActions = (clone $baseQuery)
            ->select(
                'activities.action',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('activities.action')
            ->orderByDesc('total')
            ->limit(3)
            ->get();
        $totalForProgress = $totalActivities;

        return view('environments.dashboard.content', compact(
            'totalActivities',
            'totalActiveUsers',
            'totalActions',
            'topUserActivities',
            'actions',
            'from',
            'to',
            'action',
            'activityPerDay',
            'topUsers',
            'topActions',
            'totalForProgress'
        ));
    }
}

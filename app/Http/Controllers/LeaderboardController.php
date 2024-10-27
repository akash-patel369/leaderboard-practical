<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->withCount('activities')
            ->orderBy('total_points', 'desc')
            ->orderBy('rank');

        if ($request->has('day')) {
            $query->whereHas('activities', function ($q) {
                $q->whereDate('activity_date', Carbon::today());
            });
        } elseif ($request->has('month')) {
            $query->whereHas('activities', function ($q) {
                $q->whereMonth('activity_date', Carbon::now()->month);
            });
        } elseif ($request->has('year')) {
            $query->whereHas('activities', function ($q) {
                $q->whereYear('activity_date', Carbon::now()->year);
            });
        }

        if ($request->has('user_id')) {
            $query->where('id', $request->input('user_id'));
        }

        $users = $query->get();

        return view('leaderboard.index', compact('users'));
    }

    public function recalculate()
    {
        $users = User::with('activities')->get();

        foreach ($users as $user) {
            $user->total_points = $user->activities->count() * 20;
            $user->save();
        }

        $rankedUsers = User::orderByDesc('total_points')->get();

        $currentRank = 0;
        $previousPoints = null;

        foreach ($rankedUsers as $index => $user) {
            // If the current user's points differ from the previous, assign a new rank
            if ($user->total_points !== $previousPoints) {
                $currentRank = $currentRank + 1;
            }

            // Assign calculated rank to the user
            $user->rank = $currentRank;
            $user->save();

            // Update previous points to the current user's points for next iteration
            $previousPoints = $user->total_points;
        }

        return redirect()->route('leaderboard.index');
    }
}

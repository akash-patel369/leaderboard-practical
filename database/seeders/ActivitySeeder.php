<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (User::all() as $user) {
            $points = 20;
            $totalPoints = 0;

            for ($i = 0; $i < rand(5, 10); $i++) {
                UserActivity::create([
                    'user_id' => $user->id,
                    'points' => $points,
                    'activity_date' => Carbon::now()->subDays(rand(0, 30)),
                ]);

                $totalPoints += $points;
            }

            // Update user's total points
            $user->total_points = $totalPoints;
            $user->save();
        }

        // Rank users based on total points
        $users = User::orderByDesc('total_points')->get();
        $rank = 1;

        foreach ($users as $user) {
            $user->rank = $rank;
            $user->save();

            // Increment rank for the next user only if the points differ
            $nextUser = $users->get($rank) ?? null;
            if ($nextUser && $nextUser->total_points != $user->total_points) {
                $rank++;
            }
        }
    }
}

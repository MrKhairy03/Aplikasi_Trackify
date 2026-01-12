<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            return;
        }

        $actions = [
            'login',
            'view_dashboard',
            'view_activities',
            'logout',
        ];

        $activities = [];
        $totalData = 10000;

        for ($i = 0; $i < $totalData; $i++) {
            $randomDate = Carbon::now()
                ->subDays(rand(0, 30))
                ->subMinutes(rand(0, 1440));

            $activities[] = [
                'user_id'    => $userIds[array_rand($userIds)],
                'action'     => $actions[array_rand($actions)],
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ];
        }

        foreach (array_chunk($activities, 1000) as $chunk) {
            DB::table('activities')->insert($chunk);
        }
    }
}

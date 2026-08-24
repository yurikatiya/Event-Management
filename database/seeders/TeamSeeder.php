<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Indra Epenk', 'Creative Director'],
            ['Carin', 'Activation Manager'],
            ['Rizky', 'Community Dev'],
            ['Aris', 'General Affair'],
            ['Cilla', 'HRD & Admin'],
            ['Rindy', 'Finance Director'],
        ] as $order => [$name, $position]) {
            Team::updateOrCreate(
                ['name' => $name],
                ['position' => $position, 'order' => $order + 1, 'status' => 'published', 'bio' => "{$name} merupakan bagian dari team INCO."],
            );
        }
    }
}
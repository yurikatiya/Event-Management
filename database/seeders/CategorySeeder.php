<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'description' => 'For developer meetups, conferences, workshops, and product launches.'],
            ['name' => 'Art & Design', 'description' => 'Design exhibitions, gallery events, digital art festivals, and seminars.'],
            ['name' => 'Networking', 'description' => 'Career fairs, corporate retreats, happy hours, and match-making events.'],
            ['name' => 'Environment', 'description' => 'Sustainability forums, recycling drives, and green energy exhibitions.'],
            ['name' => 'Healthcare', 'description' => 'Medical research panels, health expos, and public wellness seminars.'],
            ['name' => 'Music Festivals', 'description' => 'Concerts, local band showcases, outdoor gigs, and DJ performance shows.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}

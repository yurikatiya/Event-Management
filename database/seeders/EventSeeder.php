<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('username', 'admin')->first() ?? User::where('role', 'admin')->first();

        if (! $admin) {
            return;
        }

        $events = [
            [
                'category' => 'Technology',
                'name' => 'Tech Summit 2026',
                'description' => 'Technology conference for developers, founders, and digital innovators.',
                'start_date' => '2026-08-20',
                'end_date' => '2026-08-20',
                'start_time' => '09:00',
                'end_time' => '17:00',
                'location' => 'Jakarta Convention Center',
                'address' => 'Jl. Gatot Subroto, Jakarta',
                'organizer' => 'R27 Creative Agency',
                'status' => 'ongoing',
            ],
            [
                'category' => 'Art & Design',
                'name' => 'Design Week Jakarta',
                'description' => 'A week-long celebration of design, creativity, and visual culture.',
                'start_date' => '2026-09-15',
                'end_date' => '2026-09-19',
                'start_time' => '10:00',
                'end_time' => '20:00',
                'location' => 'Senayan City Hall',
                'address' => 'Jl. Asia Afrika, Jakarta',
                'organizer' => 'R27 Creative Agency',
                'status' => 'draft',
            ],
            [
                'category' => 'Networking',
                'name' => 'StartupFest Indonesia',
                'description' => 'Connect with founders, investors, and the growing startup community.',
                'start_date' => '2026-10-03',
                'end_date' => '2026-10-03',
                'start_time' => '09:00',
                'end_time' => '18:00',
                'location' => 'ICE BSD City',
                'address' => 'Jl. BSD Grand Boulevard, Tangerang',
                'organizer' => 'R27 Creative Agency',
                'status' => 'ongoing',
            ],
            [
                'category' => 'Technology',
                'name' => 'Hackathon Nasional',
                'description' => 'A national coding challenge to build meaningful digital solutions.',
                'start_date' => '2026-10-18',
                'end_date' => '2026-10-19',
                'start_time' => '08:00',
                'end_time' => '20:00',
                'location' => 'Online',
                'address' => null,
                'organizer' => 'R27 Creative Agency',
                'status' => 'upcoming',
            ],
            [
                'category' => 'Environment',
                'name' => 'Creative Economy Expo',
                'description' => 'An exhibition showcasing creative businesses and sustainable ideas.',
                'start_date' => '2026-11-05',
                'end_date' => '2026-11-08',
                'start_time' => '10:00',
                'end_time' => '21:00',
                'location' => 'Jakarta International Expo',
                'address' => 'Jl. Benyamin Sueb, Jakarta',
                'organizer' => 'R27 Creative Agency',
                'status' => 'draft',
            ],
        ];

        foreach ($events as $eventData) {
            $category = Category::firstOrCreate(['name' => $eventData['category']]);
            unset($eventData['category']);

            Event::updateOrCreate(
                ['name' => $eventData['name']],
                $eventData + [
                    'category_id' => $category->id,
                    'created_by' => $admin->id,
                ],
            );
        }
    }
}

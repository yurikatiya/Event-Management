<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Creative Agency',
            'Venue Activation',
            'City Branding',
            'Event Planner & Consultant',
            'Event Organizer',
            'Design & Digital Agency',
        ];

        Service::whereNotIn('name', $services)->delete();

        foreach ($services as $name) {
            Service::updateOrCreate(
                ['name' => $name],
                ['description' => "Layanan {$name} INCO.", 'status' => 'published'],
            );
        }
    }
}
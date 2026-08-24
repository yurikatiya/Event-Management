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
            ['Bokaba', 'Creative Event', '2016-01-01', '2016-12-31', '-'],
            ['Cikalfest', 'Festival', '2017-01-01', '2017-12-31', '-'],
            ['4FUN', 'Creative Event', '2018-01-01', '2018-12-31', '-'],
            ['Reborn', 'Creative Event', '2018-01-01', '2018-12-31', '-'],
            ['Indonesia Damai', 'Community', '2019-01-01', '2019-12-31', '-'],
            ['Musicland', 'Creative Event', '2019-01-01', '2019-12-31', '-'],
            ['Pasar Cerdas', 'Community', '2020-01-01', '2020-12-31', '-'],
            ['Digigame', 'Game & Digital', '2022-01-01', '2023-12-31', 'Jakarta, Bandung, Klaten'],
            ['Pendampingan Kurikulum Gim', 'Education', '2022-01-01', '2023-12-31', 'Jakarta'],
            ['Aktivasi Game Masuk Sekolah', 'Education', null, null, '-'],
            ['West Java Belt', 'City Branding', '2024-01-01', '2024-12-31', '-'],
            ['Mercedez Carnaval', 'Festival', '2024-01-01', '2024-12-31', '-'],
            ['Sangkuriang Festival', 'Festival', '2025-01-01', '2025-12-31', '-'],
            ['Batikday', 'Creative Event', '2025-01-01', '2025-12-31', '-'],
            ['Curious People', 'Creative Event', '2025-01-01', '2025-12-31', '-'],
            ['GEKRAFS Jabar Gebrakan', 'Community', '2025-01-01', '2025-12-31', 'Jawa Barat'],
            ['Digigame Movement 2022-2023', 'Game & Digital', '2022-01-01', '2023-12-31', 'Jakarta, Bandung, Klaten'],
            ['Digigame Movement Bandung 2022-2023', 'Game & Digital', '2022-01-01', '2023-12-31', 'Bandung'],
            ['Creativepreneur Program', 'Education', null, null, '-'],
            ['Pendampingan SMK Kelas Game Dev 2023', 'Education', '2023-01-01', '2023-12-31', '-'],
            ['Magang Guru RPL & Game Dev (2023)', 'Education', '2023-01-01', '2023-12-31', '-'],
            ['PKL SMK 11 Semarang (2024)', 'Education', '2024-01-01', '2024-12-31', 'Semarang'],
            ['Kerjasama Kelas Industri SMK Santana Indonesia (2024)', 'Collaboration', '2024-01-01', '2024-12-31', '-'],
            ['PKL SMK di INCO Indonesia', 'Education', null, null, '-'],
            ['Kolaborasi Kampus & GEKRAFS', 'Collaboration', null, null, '-'],
            ['Kolaborasi SMK dalam Program Digigame', 'Collaboration', null, null, '-'],
            ['RW Cerdas (2018)', 'Community', '2018-01-01', '2018-12-31', '-'],
            ['Community Support (2020-2024)', 'Community', '2020-01-01', '2024-12-31', '-'],
            ['Aktivasi Komunitas Kreatif', 'Community', null, null, '-'],
            ['Kolaborasi GEKRAFS Jabar & Chlorine', 'Collaboration', null, null, '-'],
        ];

        Event::whereIn('name', [
            'Tech Summit 2026',
            'Design Week Jakarta',
            'StartupFest Indonesia',
            'Hackathon Nasional',
            'Creative Economy Expo',
        ])->delete();

        foreach ($events as [$name, $categoryName, $startDate, $endDate, $location]) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            Event::updateOrCreate(
                ['name' => $name],
                [
                    'description' => "{$name} oleh R27 Creative Agency.",
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'location' => $location,
                    'status' => 'published',
                    'category_id' => $category->id,
                    'created_by' => $admin->id,
                ],
            );
        }
    }
}

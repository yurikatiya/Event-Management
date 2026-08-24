<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['GEKRAFS Jabar', 'Creative Industry'],
            ['Chlorine', 'Company'],
            ['Telkom University', 'Education'],
            ['UPI', 'Education'],
            ['R27 Creative Agency', 'Creative Industry'],
            ['Digital Breeze', 'Company'],
            ['Metalabs', 'Company'],
        ];

        Partner::whereNotIn('name', array_column($partners, 0))->delete();

        foreach ($partners as [$name, $category]) {
            Partner::updateOrCreate(
                ['name' => $name],
                [
                    'category' => $category,
                    'description' => "Kolaborasi INCO bersama {$name}.",
                    'status' => 'published',
                ],
            );
        }
    }
}
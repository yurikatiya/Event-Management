<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Festival', 'description' => 'Large-scale celebrations featuring performances, activities, and entertainment.'],
            ['name' => 'Creative Event', 'description' => 'Events focused on creativity, art, design, and cultural expression.'],
            ['name' => 'Education', 'description' => 'Learning programs, seminars, conferences, and knowledge-sharing events.'],
            ['name' => 'Community', 'description' => 'Events that bring local communities together through shared interests and activities.'],
            ['name' => 'Game & Digital', 'description' => 'Gaming, technology, digital culture, and interactive experiences.'],
            ['name' => 'City Branding', 'description' => 'Events that promote a city identity, destination, or local potential.'],
            ['name' => 'Workshop', 'description' => 'Hands-on sessions for developing practical skills and knowledge.'],
            ['name' => 'Collaboration', 'description' => 'Joint events created through partnerships between people, groups, or organizations.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }

        $legacyCategories = [
            'Technology' => 'Game & Digital',
            'Art & Design' => 'Creative Event',
            'Networking' => 'Collaboration',
            'Environment' => 'City Branding',
            'Healthcare' => 'Education',
            'Music Festivals' => 'Festival',
        ];

        foreach ($legacyCategories as $oldName => $newName) {
            $oldCategory = Category::where('name', $oldName)->first();
            $newCategory = Category::where('name', $newName)->first();

            if ($oldCategory && $newCategory) {
                Event::where('category_id', $oldCategory->id)
                    ->update(['category_id' => $newCategory->id]);
                $oldCategory->delete();
            }
        }
    }
}

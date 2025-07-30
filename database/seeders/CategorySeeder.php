<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Site;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sites = Site::all();

        foreach ($sites as $site) {
            if ($site->name === 'Corporate Website') {
                $categories = [
                    ['name' => 'Services', 'slug' => 'services', 'description' => 'Our company services', 'color' => '#3B82F6'],
                    ['name' => 'About Us', 'slug' => 'about-us', 'description' => 'Company information', 'color' => '#10B981'],
                    ['name' => 'News', 'slug' => 'news', 'description' => 'Company news and updates', 'color' => '#F59E0B'],
                ];
            } elseif ($site->name === 'Tech Blog') {
                $categories = [
                    ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Latest tech trends', 'color' => '#7C3AED'],
                    ['name' => 'Programming', 'slug' => 'programming', 'description' => 'Programming tutorials', 'color' => '#DC2626'],
                    ['name' => 'AI & Machine Learning', 'slug' => 'ai-ml', 'description' => 'Artificial Intelligence articles', 'color' => '#059669'],
                    ['name' => 'Web Development', 'slug' => 'web-dev', 'description' => 'Web development tips', 'color' => '#EA580C'],
                ];
            } else { // E-Commerce Store
                $categories = [
                    ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic products', 'color' => '#1F2937'],
                    ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Fashion and apparel', 'color' => '#DB2777'],
                    ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Home and garden items', 'color' => '#65A30D'],
                ];
            }

            foreach ($categories as $category) {
                Category::create([
                    'site_id' => $site->id,
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                    'description' => $category['description'],
                    'color' => $category['color'],
                    'sort_order' => 0,
                    'is_active' => true,
                ]);
            }
        }
    }
}

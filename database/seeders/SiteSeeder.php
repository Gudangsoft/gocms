<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Site;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sites = [
            [
                'name' => 'Corporate Website',
                'domain' => 'corporate.example.com',
                'subdomain' => null,
                'description' => 'Main corporate website for business portfolio',
                'settings' => [
                    'email' => 'info@corporate.example.com',
                    'phone' => '+1234567890',
                    'address' => '123 Business Street, City, Country'
                ],
                'theme_settings' => [
                    'primary_color' => '#3B82F6',
                    'secondary_color' => '#10B981',
                    'font_family' => 'Inter'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Tech Blog',
                'domain' => 'blog.example.com', 
                'subdomain' => null,
                'description' => 'Technology and innovation blog',
                'settings' => [
                    'email' => 'blog@blog.example.com',
                    'social_media' => [
                        'twitter' => '@techblog',
                        'linkedin' => 'company/techblog'
                    ]
                ],
                'theme_settings' => [
                    'primary_color' => '#7C3AED',
                    'secondary_color' => '#F59E0B',
                    'font_family' => 'Inter'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'E-Commerce Store',
                'domain' => 'shop.example.com',
                'subdomain' => null,
                'description' => 'Online store for products and services',
                'settings' => [
                    'email' => 'shop@shop.example.com',
                    'currency' => 'USD',
                    'payment_methods' => ['stripe', 'paypal']
                ],
                'theme_settings' => [
                    'primary_color' => '#EF4444',
                    'secondary_color' => '#059669', 
                    'font_family' => 'Inter'
                ],
                'is_active' => true,
            ]
        ];

        foreach ($sites as $site) {
            Site::create($site);
        }
    }
}

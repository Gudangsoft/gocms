<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\Site;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $site = Site::first();
        
        if (!$site) {
            $this->command->info('No sites found. Please run SiteSeeder first.');
            return;
        }

        $settings = [
            [
                'site_id' => $site->id,
                'key' => 'copyright_text',
                'value' => '© 2025 GO CMS. All rights reserved.',
                'type' => 'text',
                'label' => 'Copyright Text',
                'description' => 'Text displayed in the website footer for copyright notice.',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'company_name',
                'value' => 'GO CMS',
                'type' => 'text',
                'label' => 'Company Name',
                'description' => 'The name of your company or organization.',
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'footer_text',
                'value' => 'Powered by GO CMS - Multi-Site Content Management System',
                'type' => 'textarea',
                'label' => 'Footer Text',
                'description' => 'Additional text displayed in the footer section.',
                'sort_order' => 30,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'contact_email',
                'value' => 'info@example.com',
                'type' => 'email',
                'label' => 'Contact Email',
                'description' => 'Main contact email address for the website.',
                'sort_order' => 40,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'site_logo',
                'value' => '/images/logo.png',
                'type' => 'url',
                'label' => 'Site Logo',
                'description' => 'URL or path to the site logo image.',
                'sort_order' => 50,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode to show a coming soon page.',
                'sort_order' => 60,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'meta_description',
                'value' => 'GO CMS is a powerful multi-site content management system built with Laravel.',
                'type' => 'textarea',
                'label' => 'Default Meta Description',
                'description' => 'Default meta description for pages that don\'t have their own.',
                'sort_order' => 70,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/yourpage',
                'type' => 'url',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL for social media links.',
                'sort_order' => 80,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/yourhandle',
                'type' => 'url',
                'label' => 'Twitter URL',
                'description' => 'Twitter profile URL for social media links.',
                'sort_order' => 90,
                'is_active' => true,
            ],
            [
                'site_id' => $site->id,
                'key' => 'analytics_code',
                'value' => '',
                'type' => 'textarea',
                'label' => 'Analytics Code',
                'description' => 'Google Analytics or other tracking code to be inserted in the head section.',
                'sort_order' => 100,
                'is_active' => false,
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                [
                    'site_id' => $setting['site_id'],
                    'key' => $setting['key']
                ],
                $setting
            );
        }

        $this->command->info('Default site settings created successfully!');
    }
}

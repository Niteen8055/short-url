<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            [
                'name' => 'Free',
                'price' => 0,
                'qr_codes_limit' => 2,
                'links_limit' => 10,
                'landing_pages_limit' => 1,
                'back_halves_limit' => 5,
                'click_data_duration' => 0, // Unlimited clicks & scans
                'utm_builder' => false,
                'qr_customizations' => true,
                'redirects' => false,
                'custom_domain' => false,
                'branded_links' => false,
                'bulk_link_shortening_limit' => null,
                'click_scan_data_duration' => 0, // Unlimited data
            ],
            [
                'name' => 'Core',
                'price' => 8,
                'qr_codes_limit' => 5,
                'links_limit' => 100,
                'landing_pages_limit' => 3,
                'back_halves_limit' => 30,
                'click_data_duration' => 30,
                'utm_builder' => true,
                'qr_customizations' => true,
                'redirects' => true,
                'custom_domain' => false,
                'branded_links' => false,
                'bulk_link_shortening_limit' => null,
                'click_scan_data_duration' => 30, // 30 days of click & scan data
            ],
            [
                'name' => 'Growth',
                'price' => 29,
                'qr_codes_limit' => 10,
                'links_limit' => 500,
                'landing_pages_limit' => 5,
                'back_halves_limit' => 60,
                'click_data_duration' => 120,
                'utm_builder' => true,
                'qr_customizations' => true,
                'redirects' => true,
                'custom_domain' => true,
                'branded_links' => true,
                'bulk_link_shortening_limit' => 100,
                'click_scan_data_duration' => 120, // 4 months of click & scan data
            ],
            [
                'name' => 'Premium',
                'price' => 199,
                'qr_codes_limit' => 200,
                'links_limit' => 3000,
                'landing_pages_limit' => 10,
                'back_halves_limit' => 100,
                'click_data_duration' => 365,
                'utm_builder' => true,
                'qr_customizations' => true,
                'redirects' => true,
                'custom_domain' => true,
                'branded_links' => true,
                'bulk_link_shortening_limit' => 500,
                'click_scan_data_duration' => 365, // 1 year of click & scan data
            ]
        ]);
    }
    
}

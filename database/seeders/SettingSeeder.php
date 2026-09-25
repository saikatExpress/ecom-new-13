<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            // General Settings
            [
                'group_name'  => 'general',
                'setting_key' => 'site_name',
                'label'       => 'Site Name',
                'value'       => 'My Ecommerce',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'site_tagline',
                'label'       => 'Site Tagline',
                'value'       => 'Best Online Shopping Experience',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'invoice_prefix',
                'label'       => 'Invoice Prefix',
                'value'       => 'INV',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'invoice_sequence',
                'label'       => 'Invoice Sequence',
                'value'       => 0,
                'type'        => 'number'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'support_email',
                'label'       => 'Support Email',
                'value'       => 'support@myecommerce.com',
                'type'        => 'email'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'support_phone',
                'label'       => 'Support Phone',
                'value'       => '+8801700000000',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'store_address',
                'label'       => 'Store Address',
                'value'       => 'Dhaka, Bangladesh',
                'type'        => 'textarea'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'currency_code',
                'label'       => 'Currency Code',
                'value'       => 'BDT',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'currency_symbol',
                'label'       => 'Currency Symbol',
                'value'       => '৳',
                'type'        => 'string'
            ],

            // Logo Setting
            [
                'group_name'  => 'logo',
                'setting_key' => 'site_favicon',
                'label'       => 'Site Favicon',
                'value'       => 'assets/images/favicon.ico',
                'type'        => 'image'
            ],
            [
                'group_name'  => 'logo',
                'setting_key' => 'header_logo',
                'label'       => 'Header Logo',
                'value'       => 'assets/images/favicon.ico',
                'type'        => 'image'
            ],
            [
                'group_name'  => 'logo',
                'setting_key' => 'footer_logo',
                'label'       => 'Footer Logo',
                'value'       => 'assets/images/favicon.ico',
                'type'        => 'image'
            ],
            [
                'group_name'  => 'logo',
                'setting_key' => 'social_logo',
                'label'       => 'Social Logo',
                'value'       => 'assets/images/favicon.ico',
                'type'        => 'image'
            ],

            // Theme & UI Settings (Frontend Customization)
            [
                'group_name'  => 'theme',
                'setting_key' => 'primary_color',
                'label'       => 'Primary Color',
                'value'       => '#FF5722', // Brand Color
                'type'        => 'color'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'secondary_color',
                'label'       => 'Secondary Color',
                'value'       => '#212121', // Dark Gray
                'type'        => 'color'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'background_color',
                'label'       => 'Background Color',
                'value'       => '#F8F9FA',
                'type'        => 'color'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'text_color',
                'label'       => 'Body Text Color',
                'value'       => '#333333',
                'type'        => 'color'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'heading_font',
                'label'       => 'Heading Font Family',
                'value'       => 'Poppins, sans-serif',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'body_font',
                'label'       => 'Body Font Family',
                'value'       => 'Roboto, sans-serif',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'add_to_cart_button_text',
                'label'       => 'Add To Cart Text',
                'value'       => 'Add to Cart',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'buy_now_button_text',
                'label'       => 'Buy Now Text',
                'value'       => 'Buy Now',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'header_layout',
                'label'       => 'Header Layout Style',
                'value'       => 'style_1', // Can be style_1, style_2 etc.
                'type'        => 'select'
            ],

            // Product & Catalog Settings
            [
                'group_name'  => 'product',
                'setting_key' => 'refund_policy',
                'label'       => 'Refund Policy',
                'value'       => "",
                'type'        => 'textarea'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'why_choose_us',
                'label'       => 'Why Choose Us',
                'value'       => "",
                'type'        => 'textarea'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'is_subcategory_show',
                'label'       => 'Is Sub Category Show',
                'value'       => 1,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'is_subsubcategory_show',
                'label'       => 'Is Sub Sub Category Show',
                'value'       => 1,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'is_stock_maintain',
                'label'       => 'Is Stock Maintain',
                'value'       => 1,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'is_negative_stock_allow',
                'label'       => 'Is Negative Stock Allow',
                'value'       => 1,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'enable_product_reviews',
                'label'       => 'Enable Product Reviews',
                'value'       => true,
                'type'        => 'boolean'
            ],

            // Shipping Settings
            [
                'group_name'  => 'shipping',
                'setting_key' => 'delivery_charge_inside_city',
                'label'       => 'Delivery Charge (Inside City)',
                'value'       => 60,
                'type'        => 'number'
            ],
            [
                'group_name'  => 'shipping',
                'setting_key' => 'delivery_charge_outside_city',
                'label'       => 'Delivery Charge (Outside City)',
                'value'       => 120,
                'type'        => 'number'
            ],
            [
                'group_name'  => 'shipping',
                'setting_key' => 'free_shipping_threshold',
                'label'       => 'Free Shipping Amount',
                'value'       => 5000, // Order above this gets free shipping
                'type'        => 'number'
            ],

            // Payment Gateway Toggles
            [
                'group_name'  => 'payment',
                'setting_key' => 'cod_enabled',
                'label'       => 'Cash On Delivery Enabled',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'payment',
                'setting_key' => 'bkash_enabled',
                'label'       => 'bKash Enabled',
                'value'       => false,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'payment',
                'setting_key' => 'sslcommerz_enabled',
                'label'       => 'SSLCommerz Enabled',
                'value'       => false,
                'type'        => 'boolean'
            ],

            // Social Media Links
            [
                'group_name'  => 'social',
                'setting_key' => 'facebook_url',
                'label'       => 'Facebook URL',
                'value'       => 'https://facebook.com/myecommerce',
                'type'        => 'url'
            ],
            [
                'group_name'  => 'social',
                'setting_key' => 'youtube_url',
                'label'       => 'YouTube URL',
                'value'       => 'https://youtube.com/myecommerce',
                'type'        => 'url'
            ],

            // SEO & Analytics
            [
                'group_name'  => 'seo',
                'setting_key' => 'meta_title',
                'label'       => 'Default Meta Title',
                'value'       => 'My Ecommerce - Best Online Shop',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'seo',
                'setting_key' => 'meta_description',
                'label'       => 'Default Meta Description',
                'value'       => 'Buy the best products at the cheapest prices from My Ecommerce.',
                'type'        => 'textarea'
            ],
            [
                'group_name'  => 'seo',
                'setting_key' => 'google_analytics_id',
                'label'       => 'Google Analytics Measurement ID',
                'value'       => '',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'seo',
                'setting_key' => 'facebook_pixel_id',
                'label'       => 'Facebook Pixel ID',
                'value'       => '',
                'type'        => 'string'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                [
                    'group_name'  => $setting['group_name'],
                    'setting_key' => $setting['setting_key'],
                ],
                array_merge($setting, [
                    'autoload' => true,
                ])
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            /*
            |--------------------------------------------------------------------------
            | General
            |--------------------------------------------------------------------------
            */

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
                'value'       => '',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'site_description',
                'label'       => 'Site Description',
                'value'       => '',
                'type'        => 'textarea'
            ],

            [
                'group_name'  => 'general',
                'setting_key' => 'logo',
                'label'       => 'Logo',
                'value'       => '',
                'type'        => 'image'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'favicon',
                'label'       => 'Favicon',
                'value'       => '',
                'type'        => 'image'
            ],

            [
                'group_name'  => 'general',
                'setting_key' => 'support_email',
                'label'       => 'Support Email',
                'value'       => '',
                'type'        => 'email'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'support_phone',
                'label'       => 'Support Phone',
                'value'       => '',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'whatsapp_number',
                'label'       => 'Whatsapp',
                'value'       => '',
                'type'        => 'string'
            ],

            [
                'group_name'  => 'general',
                'setting_key' => 'address',
                'label'       => 'Address',
                'value'       => '',
                'type'        => 'textarea'
            ],

            [
                'group_name'  => 'general',
                'setting_key' => 'currency',
                'label'       => 'Currency',
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
            [
                'group_name'  => 'general',
                'setting_key' => 'currency_position',
                'label'       => 'Currency Position',
                'value'       => 'left',
                'type'        => 'select'
            ],

            [
                'group_name'  => 'general',
                'setting_key' => 'timezone',
                'label'       => 'Timezone',
                'value'       => 'Asia/Dhaka',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'general',
                'setting_key' => 'maintenance_mode',
                'label'       => 'Maintenance Mode',
                'value'       => false,
                'type'        => 'boolean'
            ],

            /*
            |--------------------------------------------------------------------------
            | Auth
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'auth',
                'setting_key' => 'login_otp_enabled',
                'label'       => 'Login OTP',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'auth',
                'setting_key' => 'register_otp_enabled',
                'label'       => 'Register OTP',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'auth',
                'setting_key' => 'forgot_password_otp_enabled',
                'label'       => 'Forgot Password OTP',
                'value'       => true,
                'type'        => 'boolean'
            ],

            [
                'group_name'  => 'auth',
                'setting_key' => 'require_phone_verification',
                'label'       => 'Phone Verification',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'auth',
                'setting_key' => 'require_email_verification',
                'label'       => 'Email Verification',
                'value'       => false,
                'type'        => 'boolean'
            ],

            [
                'group_name'  => 'auth',
                'setting_key' => 'otp_length',
                'label'       => 'OTP Length',
                'value'       => 6,
                'type'        => 'number'
            ],
            [
                'group_name'  => 'auth',
                'setting_key' => 'otp_expire_minutes',
                'label'       => 'OTP Expire',
                'value'       => 5,
                'type'        => 'number'
            ],

            /*
            |--------------------------------------------------------------------------
            | Order
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'order',
                'setting_key' => 'order_prefix',
                'label'       => 'Order Prefix',
                'value'       => 'ORD',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'order',
                'setting_key' => 'invoice_prefix',
                'label'       => 'Invoice Prefix',
                'value'       => 'INV',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'order',
                'setting_key' => 'invoice_start',
                'label'       => 'Invoice Start',
                'value'       => 1000,
                'type'        => 'number'
            ],

            [
                'group_name'  => 'order',
                'setting_key' => 'guest_checkout',
                'label'       => 'Guest Checkout',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'order',
                'setting_key' => 'minimum_order_amount',
                'label'       => 'Minimum Order',
                'value'       => 0,
                'type'        => 'number'
            ],
            [
                'group_name'  => 'order',
                'setting_key' => 'return_days',
                'label'       => 'Return Days',
                'value'       => 7,
                'type'        => 'number'
            ],

            /*
            |--------------------------------------------------------------------------
            | Shipping
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'shipping',
                'setting_key' => 'free_shipping_enabled',
                'label'       => 'Free Shipping',
                'value'       => false,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'shipping',
                'setting_key' => 'free_shipping_minimum_amount',
                'label'       => 'Free Shipping Minimum',
                'value'       => 1000,
                'type'        => 'number'
            ],
            [
                'group_name'  => 'shipping',
                'setting_key' => 'default_delivery_charge',
                'label'       => 'Delivery Charge',
                'value'       => 80,
                'type'        => 'number'
            ],

            /*
            |--------------------------------------------------------------------------
            | Product
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'product',
                'setting_key' => 'show_stock',
                'label'       => 'Show Stock',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'show_sku',
                'label'       => 'Show SKU',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'show_reviews',
                'label'       => 'Show Reviews',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'product',
                'setting_key' => 'default_stock',
                'label'       => 'Default Stock',
                'value'       => 0,
                'type'        => 'number'
            ],

            /*
            |--------------------------------------------------------------------------
            | Review
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'review',
                'setting_key' => 'review_enabled',
                'label'       => 'Review Enabled',
                'value'       => true,
                'type'        => 'boolean'
            ],
            [
                'group_name'  => 'review',
                'setting_key' => 'review_after_purchase_only',
                'label'       => 'Verified Purchase Review',
                'value'       => true,
                'type'        => 'boolean'
            ],

            /*
            |--------------------------------------------------------------------------
            | Coupon
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'coupon',
                'setting_key' => 'coupon_enabled',
                'label'       => 'Coupon Enabled',
                'value'       => true,
                'type'        => 'boolean'
            ],

            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'inventory',
                'setting_key' => 'low_stock_limit',
                'label'       => 'Low Stock Alert',
                'value'       => 5,
                'type'        => 'number'
            ],
            [
                'group_name'  => 'inventory',
                'setting_key' => 'negative_stock',
                'label'       => 'Negative Stock',
                'value'       => false,
                'type'        => 'boolean'
            ],

            /*
            |--------------------------------------------------------------------------
            | Social
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'social',
                'setting_key' => 'facebook',
                'label'       => 'Facebook',
                'value'       => '',
                'type'        => 'url'
            ],
            [
                'group_name'  => 'social',
                'setting_key' => 'instagram',
                'label'       => 'Instagram',
                'value'       => '',
                'type'        => 'url'
            ],
            [
                'group_name'  => 'social',
                'setting_key' => 'youtube',
                'label'       => 'Youtube',
                'value'       => '',
                'type'        => 'url'
            ],
            [
                'group_name'  => 'social',
                'setting_key' => 'linkedin',
                'label'       => 'Linkedin',
                'value'       => '',
                'type'        => 'url'
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'seo',
                'setting_key' => 'meta_title',
                'label'       => 'Meta Title',
                'value'       => '',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'seo',
                'setting_key' => 'meta_description',
                'label'       => 'Meta Description',
                'value'       => '',
                'type'        => 'textarea'
            ],
            [
                'group_name'  => 'seo',
                'setting_key' => 'meta_keywords',
                'label'       => 'Meta Keywords',
                'value'       => '',
                'type'        => 'textarea'
            ],

            /*
            |--------------------------------------------------------------------------
            | Theme
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'theme',
                'setting_key' => 'primary_color',
                'label'       => 'Primary Color',
                'value'       => '#0d6efd',
                'type'        => 'color'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'secondary_color',
                'label'       => 'Secondary Color',
                'value'       => '#198754',
                'type'        => 'color'
            ],

            [
                'group_name'  => 'theme',
                'setting_key' => 'cart_button_text',
                'label'       => 'Cart Button Text',
                'value'       => 'Add To Cart',
                'type'        => 'string'
            ],
            [
                'group_name'  => 'theme',
                'setting_key' => 'buy_now_button_text',
                'label'       => 'Buy Now Button Text',
                'value'       => 'Buy Now',
                'type'        => 'string'
            ],

            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            [
                'group_name'  => 'contact',
                'setting_key' => 'google_map',
                'label'       => 'Google Map',
                'value'       => '',
                'type'        => 'textarea'
            ],

        ];

        foreach ($settings as $setting) {

            Setting::updateOrCreate(
                [
                    'group_name' => $setting['group_name'],
                    'setting_key' => $setting['setting_key'],
                ],
                array_merge($setting, [
                    'autoload' => true,
                ])
            );

        }
    }
}

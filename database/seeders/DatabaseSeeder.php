<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Blog\BlogTagSeeder;
use Database\Seeders\Blog\BlogPostSeeder;
use Database\Seeders\Product\BrandSeeder;
use Database\Seeders\Product\ProductSeeder;
use Database\Seeders\Product\CategorySeeder;
use Database\Seeders\Order\OrderSourceSeeder;
use Database\Seeders\Product\AttributeSeeder;
use Database\Seeders\Blog\BlogCategorySeeder;
use Database\Seeders\CMS\FaqSeeder;
use Database\Seeders\CMS\PageSeeder;
use Database\Seeders\CMS\SectionSeeder;
use Database\Seeders\Order\CancelReasonSeeder;
use Database\Seeders\Order\CourierSeeder;
use Database\Seeders\Order\CustomerTypeSeeder;
use Database\Seeders\Product\SubCategorySeeder;
use Database\Seeders\Order\PaymentGatewaySeeder;
use Database\Seeders\Order\DeliveryGatewaySeeder;
use Database\Seeders\Order\OrderGuardSettingSeeder;
use Database\Seeders\Order\StatusSeeder;
use Database\Seeders\Product\AttributeValueSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            UserCategorySeeder::class,
            UserSeeder::class,

            // Product Seeders
            CategorySeeder::class,
            SubCategorySeeder::class,
            BrandSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            ProductSeeder::class,
            // Product Seeders

            // CMS Seeder
            SectionSeeder::class,
            PageSeeder::class,
            FaqSeeder::class,
            // CMS Seeder

            // Order Seeders
            OrderSourceSeeder::class,
            CustomerTypeSeeder::class,
            PaymentGatewaySeeder::class,
            DeliveryGatewaySeeder::class,
            CancelReasonSeeder::class,
            CourierSeeder::class,
            StatusSeeder::class,
            OrderGuardSettingSeeder::class,
            // Order Seeders

            BlogCategorySeeder::class,
            BlogTagSeeder::class,
            BlogPostSeeder::class,
            SettingSeeder::class,
        ]);
    }
}

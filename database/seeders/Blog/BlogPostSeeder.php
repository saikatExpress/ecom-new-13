<?php

namespace Database\Seeders\Blog;

use App\Models\User;
use App\Enums\StatusEnum;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Blog\BlogTag;
use App\Models\Blog\BlogPost;
use Illuminate\Database\Seeder;
use App\Models\Blog\BlogCategory;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categoryIds = BlogCategory::pluck('id')->toArray();
        $tagIds = BlogTag::pluck('id')->toArray();

        $adminIds = User::whereHas('roles', function ($query) {
            $query->where('name', 'superadmin');
        })->pluck('id')->toArray();

        if (empty($adminIds)) {
            $adminIds = [1, 2, 3, 4, 5];
        }

        $titles = [
            "Top 5 Smartphones under 20,000 BDT in 2026",
            "Best Budget Laptops for Freelancers in Bangladesh",
            "10 Must-Have Gadgets for University Students",
            "Top 5 Smartwatches under 5,000 Taka",
            "Wireless Earbuds vs Neckbands: Which is Better?",
            "How to Choose the Right Power Bank for Your Phone",
            "Gaming PC Build Guide for Beginners in BD",
            "Best DSLR Cameras for Freelance Photographers",
            "Top 5 Mechanical Keyboards Available in Dhaka",
            "Why You Need a Smart TV in 2026",

            "Eid Shopping Guide: Best Traditional Wear for Men",
            "Jamdani Saree: History and How to Identify Authentic Ones",
            "Best Winter Jackets for Men in Bangladesh",
            "Trending Panjabi Designs for Eid 2026",
            "Summer Fashion Tips: How to Stay Cool and Stylish",
            "Top 5 Ladies Bag Brands in Bangladesh",
            "Formal Office Wear Ideas for Bangladeshi Corporate Women",
            "How to Choose the Perfect Shoe Size Online",
            "Couple T-shirt Ideas for Valentine's Day",
            "The Ultimate Guide to Buying Authentic Silk Sarees",

            "How to Choose the Right AC for Your Home in Dhaka",
            "Top 5 Refrigerators for Big Families",
            "Washing Machine Buying Guide: Top vs Front Load",
            "Microwave Oven vs Electric Oven: Which Do You Need?",
            "How to Set Up a Smart Home on a Budget in BD",
            "Best Water Purifiers for Safe Drinking Water at Home",
            "Air Purifier: Is It Really Necessary in Dhaka City?",
            "Top 5 Blenders for Everyday Kitchen Use",
            "Geyser Buying Guide for Bangladeshi Winters",
            "Best Iron and Garment Steamers for Daily Use",

            "Skincare Routine for Bangladeshi Summer",
            "Best Halal Cosmetics Brands Available in BD",
            "Winter Skincare Tips for Glowing Skin",
            "Top 5 Hair Oils to Prevent Hair Fall",
            "How to Build a Home Gym with Minimum Budget",
            "Best Yoga Mats for Home Workouts",
            "Top 10 Protein Supplements in Bangladesh",
            "Beard Care Routine for Bangladeshi Men",
            "Best Baby Care Products for Newborns",
            "Organic Foods You Should Add to Your Daily Diet",

            "How to Avoid Scams While Shopping Online in BD",
            "5 Tips to Get the Best Deals During Flash Sales",
            "How to Use Coupon Codes Properly on Our App",
            "Why bKash Payment is the Safest Way for Online Shopping",
            "How Our Fast Delivery Process Works (Inside Dhaka)",
            "Return and Refund Process: A Step-by-Step Guide",
            "Upcoming Eid Mega Campaign: What to Expect?",
            "How to Track Your Orders Easily",
            "Top 10 Gift Ideas for Your Best Friend's Wedding",
            "Why We Introduced the Try-On Feature for Sunglasses"
        ];

        foreach ($titles as $index => $title) {
            $slug = Str::slug($title);
            $excerpt = $faker->realText(150);

            $content = "<h2>Introduction</h2>";
            $content .= "<p>" . $faker->realText(400) . "</p>";
            $content .= "<h3>" . $faker->catchPhrase . "</h3>";
            $content .= "<p>" . $faker->realText(500) . "</p>";
            $content .= "<ul><li>" . $faker->sentence . "</li><li>" . $faker->sentence . "</li><li>" . $faker->sentence . "</li></ul>";
            $content .= "<p>" . $faker->realText(300) . "</p>";

            // 1. Post Create kora
            $post = BlogPost::create([
                'category_id'      => $faker->randomElement($categoryIds) ?? 1,
                'title'            => $title,
                'slug'             => $slug,
                'excerpt'          => $excerpt,
                'content'          => $content,
                'img_path'         => 'blog_images/default-blog-' . rand(1, 5) . '.jpg',
                'meta_title'       => $title,
                'meta_keywords'    => str_replace(' ', ',', $faker->words(5, true)),
                'meta_description' => $excerpt,
                'status'           => StatusEnum::ACTIVE,
                'views_count'      => rand(50, 5000),

                'created_by'       => $faker->randomElement($adminIds),
                'updated_by'       => $faker->randomElement($adminIds),
            ]);

            if (!empty($tagIds)) {
                $randomTags = $faker->randomElements($tagIds, rand(2, 4));
                $post->tags()->sync($randomTags);
            }
        }
    }
}

<?php

namespace Database\Seeders\Order;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Order\OrderSource;

class OrderSourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            [
                'name'       => 'Website',
                'color_code' => '#3B82F6',
            ],
            [
                'name'       => 'Manual',
                'color_code' => '#6B7280',
            ],
            [
                'name'       => 'WhatsApp',
                'color_code' => '#25D366',
            ],
            [
                'name'       => 'Instagram',
                'color_code' => '#E4405F',
            ],
            [
                'name'       => 'Facebook',
                'color_code' => '#1877F2',
            ],
            [
                'name'       => 'Messenger',
                'color_code' => '#0084FF',
            ],
            [
                'name'       => 'TikTok',
                'color_code' => '#000000',
            ],
            [
                'name'       => 'Phone Call',
                'color_code' => '#16A34A',
            ],
            [
                'name'       => 'Walk-in',
                'color_code' => '#F59E0B',
            ],
            [
                'name'       => 'Marketplace',
                'color_code' => '#8B5CF6',
            ],
        ];

        foreach ($sources as $source) {
            OrderSource::updateOrCreate(
                [
                    'slug' => Str::slug($source['name']),
                ],
                [
                    'name'       => $source['name'],
                    'color_code' => $source['color_code'],
                    'status'     => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}

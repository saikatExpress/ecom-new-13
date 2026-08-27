<?php

namespace Database\Seeders\Order;

use App\Models\Order\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $now = now();

        Status::insert([
            [
                "id"         => 1,
                "name"       => "New Order",
                "slug"       => "new-order",
                "bg_color"   => "#ddb063",
                "text_color" => "#ffffff",
                "icon"       => "ti-plus",
                "position"   => 1,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 2,
                "name"       => "Approved",
                "slug"       => "approved",
                "bg_color"   => "#06d14a",
                "text_color" => "#ffffff",
                "icon"       => "ti-circle-check",
                "position"   => 2,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 3,
                "name"       => "Invoiced",
                "slug"       => "invoiced",
                "bg_color"   => "#CDDC39",
                "text_color" => "#ffffff",
                "icon"       => "ti-file-invoice",
                "position"   => 4,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 4,
                "name"       => "In Courier",
                "slug"       => "in-courier",
                "bg_color"   => "#673AB7",
                "text_color" => "#ffffff",
                "icon"       => "ti-truck",
                "position"   => 5,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 5,
                "name"       => "On Hold",
                "slug"       => "on-hold",
                "bg_color"   => "#C98209",
                "text_color" => "#ffffff",
                "icon"       => "ti-pause",
                "position"   => 6,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 6,
                "name"       => "Stock Pending",
                "slug"       => "stock-pending",
                "bg_color"   => "#673AB7",
                "text_color" => "#ffffff",
                "icon"       => "ti-box",
                "position"   => 7,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 7,
                "name"       => "Delivered",
                "slug"       => "delivered",
                "bg_color"   => "#4CAF50",
                "text_color" => "#ffffff",
                "icon"       => "ti-check",
                "position"   => 8,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 8,
                "name"       => "Canceled",
                "slug"       => "canceled",
                "bg_color"   => "#F44336",
                "text_color" => "#ffffff",
                "icon"       => "ti-circle-x",
                "position"   => 9,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 9,
                "name"       => "Pending Returned",
                "slug"       => "pending-returned",
                "bg_color"   => "#9C27B0",
                "text_color" => "#ffffff",
                "icon"       => "ti-arrow-back",
                "position"   => 10,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 10,
                "name"       => "Returned",
                "slug"       => "returned",
                "bg_color"   => "#9C27B0",
                "text_color" => "#ffffff",
                "icon"       => "ti-rotate",
                "position"   => 11,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 11,
                "name"       => "Damaged",
                "slug"       => "damaged",
                "bg_color"   => "#9C27B0",
                "text_color" => "#ffffff",
                "icon"       => "ti-alert-triangle",
                "position"   => 12,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 12,
                'name'       => 'Partial Returned',
                'slug'       => 'partial-returned',
                'bg_color'   => '#9C27B0',
                'text_color' => '#ffffff',
                "icon"       => "ti-git-branch",
                'position'   => 13,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 13,
                'slug'       => 'courier-pending',
                'name'       => 'Courier Pending',
                'bg_color'   => '#b07027ff',
                'text_color' => '#ffffff',
                "icon"       => "ti-clock",
                'position'   => 14,
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id"         => 14,
                'slug'       => 'courier-received',
                'name'       => 'Courier Received',
                'bg_color'   => '#b07027ff',
                'text_color' => '#ffffff',
                "icon"       => "ti-package",
                'position'   => 15,
                "created_at" => $now,
                "updated_at" => $now
            ],
        ]);
    }
}

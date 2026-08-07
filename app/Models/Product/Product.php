<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    use HasSlug;

    // Relations
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class);
    }

    // Helper Method
    public function calculateOffer(float $mrp, float $sellPrice): array
    {
        if ($mrp > 0 && $sellPrice > 0 && $sellPrice < $mrp) {
            $discountAmount = $mrp - $sellPrice;

            return [
                'offer_price' => $sellPrice,
                'discount_amount' => $discountAmount,
                'offer_percentage' => round(($discountAmount / $mrp) * 100,2),
            ];
        }

        return [
            'offer_price' => 0,
            'discount_amount' => 0,
            'offer_percentage' => 0,
        ];
    }
}

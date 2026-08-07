<?php

namespace App\Services\Product;

use App\Exceptions\CustomException;
use App\Helpers\File\FileUploadHelper;
use App\Models\Product\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(protected Product $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $products = $this->model->query()
        ->with(['category', 'brand'])

        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        })

        ->when($request->filled('category_id'), function ($query) use ($request) {
            $query->where('category_id', $request->input('category_id'));
        })

        ->when($request->filled('brand_id'), function ($query) use ($request) {
            $query->where('brand_id', $request->input('brand_id'));
        })

        ->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->input('status'));
        })

        ->latest()

        ->paginate($paginateSize);

        return $products;
    }

    public function store($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $product = new $this->model();

                $product->name                = Str::title($request->name);
                $product->category_id         = $request->category_id;
                $product->sub_category_id     = $request->sub_category_id ?? NULL;
                $product->brand_id            = $request->brand_id ?? NULL;
                $product->sku                 = $request->sku ?? NULL;
                $product->buy_price           = $request->buy_price ?? 0;
                $product->mrp                 = $request->mrp ?? 0;
                $product->sell_price          = $request->sell_price ?? 0;

                $offer = $product->calculateOffer($product->mrp,$product->sell_price);

                $product->offer_price         = $offer['offer_price'];
                $product->discount_amount     = $offer['discount_amount'];
                $product->offer_percentage    = $offer['offer_percentage'];
                $product->current_stock       = $request->current_stock ?? NULL;
                $product->total_sell_quantity = $request->total_sell_quantity ?? NULL;
                $product->short_description   = $request->short_description ?? NULL;
                $product->description         = $request->description ?? NULL;
                $product->video_url           = $request->video_url ?? NULL;
                $product->meta_title          = $request->meta_title ?? $request->name;
                $product->meta_description    = $request->meta_description ?? NULL;
                $product->meta_keywords       = $request->meta_keywords ?? NULL;
                $product->status              = $request->status;

                if ($request->hasFile('image')) {
                    $product->img_path = FileUploadHelper::upload($request->file('image'),'products');
                }

                $product->save();

                if ($request->hasFile('gallery_images')) {
                    foreach ($request->file('gallery_images') as $image) {
                        $path = FileUploadHelper::upload($image,'products');

                        $product->galleries()->create([
                            'img_path' => $path,
                        ]);
                    }
                }

                if ($request->has('variants') && is_array($request->variants)) {
                    foreach ($request->variants as $index => $variantData) {
                        $mrp = $variantData['mrp'];
                        $sellPrice = $variantData['sell_price'];

                        $offer = $product->calculateOffer($mrp,$sellPrice);

                        $variantImagePath = null;
                        if ($request->hasFile("variants.{$index}.image")) {
                            $variantImagePath = FileUploadHelper::upload(
                                $request->file("variants.{$index}.image"),
                                'variants'
                            );
                        }

                        $variant = $product->variants()->create([
                            'sku'               => $variantData['sku'] ?? null,
                            'buy_price'         => $variantData['buy_price'] ?? null,
                            'mrp'               => $mrp,
                            'sell_price'        => $sellPrice,
                            'discount_amount'   => $offer['discount_amount'],
                            'offer_price'       => $offer['offer_price'],
                            'offer_percentage'  => $offer['offer_percentage'],
                            'img_path'          => $variantImagePath,
                            'current_stock'     => $variantData['current_stock'] ?? 0,
                            'is_default'        => $variantData['is_default'],
                            'short_description' => $variantData['short_description'] ?? NULL,
                            'description'       => $variantData['description'] ?? NULL,
                            'status'            => $variantData['status'],
                        ]);

                        if (isset($variantData['attribute_values']) && is_array($variantData['attribute_values'])) {
                            $variant->attributeValues()->attach($variantData['attribute_values']);
                        }
                    }
                }

                $product->load(['category', 'subCategory', 'brand', 'galleries', 'variants.attributeValues.attribute']);

                return $product;
            });
        } catch (\Throwable $e) {
            report($e);

            throw $e;
        }
    }

    public function show($identifier, string $type = 'id')
    {
        try {

            $query = $this->model::query();

            $product = $type === 'slug' ? $query->where('slug', $identifier)->first() : $query->find($identifier);

            if (!$product) {
                throw new CustomException('Product not found');
            }

            return $product->load(
                'category:id,name',
                'subCategory:id,name',
                'brand:id,name',
                'galleries',
                'variants.attributeValues.attribute',
            );

        } catch (Exception $e) {
            info($e);

            throw $e;
        }
    }

    public function update($request,$id)
    {
        try {
            return DB::transaction(function () use ($id, $request) {

                $product = $this->model::find($id);

                if(!$product){
                    throw new CustomException('Product not found');
                }

                $product->name                = Str::title($request->name);
                $product->category_id         = $request->category_id;
                $product->sub_category_id     = $request->sub_category_id ?? NULL;
                $product->brand_id            = $request->brand_id ?? NULL;
                $product->sku                 = $request->sku ?? NULL;
                $product->buy_price           = $request->buy_price ?? 0;
                $product->mrp                 = $request->mrp ?? 0;
                $product->sell_price          = $request->sell_price ?? 0;

                $offer = $product->calculateOffer($product->mrp, $product->sell_price);

                $product->offer_price         = $offer['offer_price'];
                $product->discount_amount     = $offer['discount_amount'];
                $product->offer_percentage    = $offer['offer_percentage'];
                $product->current_stock       = $request->current_stock ?? NULL;
                $product->total_sell_quantity = $request->total_sell_quantity ?? NULL;
                $product->short_description   = $request->short_description ?? NULL;
                $product->description         = $request->description ?? NULL;
                $product->meta_title          = $request->meta_title ?? $request->name;
                $product->meta_description    = $request->meta_description ?? NULL;
                $product->meta_keywords       = $request->meta_keywords ?? NULL;


                if ($request->hasFile('image')) {
                    $product->img_path = FileUploadHelper::replace($request->file('image'),$product->img_path,'products');
                }

                $product->save();

                // 1. Handle Gallery Deleted Image IDs
                if ($request->has('gallery_deleted_image_ids') && is_array($request->gallery_deleted_image_ids)) {
                    $galleriesToDelete = $product->galleries()->whereIn('id', $request->gallery_deleted_image_ids)->get();

                    foreach ($galleriesToDelete as $gallery) {
                        // Delete image file from storage
                        FileUploadHelper::delete($gallery->img_path);
                        // Delete database record
                        $gallery->delete();
                    }
                }

                // Gallery Images Update (Append new galleries if provided)
                if ($request->hasFile('gallery_images')) {
                    foreach ($request->file('gallery_images') as $image) {
                        $path = FileUploadHelper::upload($image, 'products');

                        $product->galleries()->create([
                            'img_path' => $path,
                        ]);
                    }
                }

                if ($request->has('variants') && is_array($request->variants)) {
                    // 1. Collect current variant IDs from request to handle deletion of missing ones
                    $requestVariantIds = collect($request->variants)->pluck('id')->filter()->toArray();

                    // Delete variants that are not present in the request
                    $variantsToDelete = $product->variants()->whereNotIn('id', $requestVariantIds)->get();
                    foreach ($variantsToDelete as $oldVariant) {
                        if ($oldVariant->img_path) {
                            FileUploadHelper::delete($oldVariant->img_path);
                        }
                        $oldVariant->attributeValues()->detach();
                        $oldVariant->delete();
                    }

                    // 2. Loop and Update/Create variants
                    foreach ($request->variants as $index => $variantData) {
                        $mrp = $variantData['mrp'];
                        $sellPrice = $variantData['sell_price'];

                        $offer = $product->calculateOffer($mrp, $sellPrice);

                        // Find existing variant or create a new one
                        $variant = $product->variants()->find($variantData['id'] ?? null);

                        // Handle Variant Image using replace or keep old one
                        $variantImagePath = $variant ? $variant->img_path : null;

                        if ($request->hasFile("variants.{$index}.image")) {
                            $variantImagePath = FileUploadHelper::replace($request->file("variants.{$index}.image"),$variantImagePath,'variants');
                        }

                        $variantDataPayload = [
                            'sku'               => $variantData['sku'] ?? null,
                            'buy_price'         => $variantData['buy_price'] ?? null,
                            'mrp'               => $mrp,
                            'sell_price'        => $sellPrice,
                            'discount_amount'   => $offer['discount_amount'],
                            'offer_price'       => $offer['offer_price'],
                            'offer_percentage'  => $offer['offer_percentage'],
                            'current_stock'     => $variantData['current_stock'] ?? 0,
                            'is_default'        => $variantData['is_default'] ?? 0,
                            'img_path'          => $variantImagePath,
                            'short_description' => $variantData['short_description'] ?? NULL,
                            'description'       => $variantData['description'] ?? NULL,
                            'status'            => 'active',
                        ];

                        if ($variant) {
                            // Update existing variant
                            $variant->update($variantDataPayload);
                        } else {
                            // Create new variant
                            $variant = $product->variants()->create($variantDataPayload);
                        }

                        // Sync or Attach Attribute Values
                        if (isset($variantData['attribute_values']) && is_array($variantData['attribute_values'])) {
                            $variant->attributeValues()->sync($variantData['attribute_values']);
                        }
                    }
                }

                $product->load(['category', 'subCategory', 'brand', 'galleries', 'variants.attributeValues.attribute']);

                return $product;
            });
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
}

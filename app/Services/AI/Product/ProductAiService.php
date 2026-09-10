<?php

namespace App\Services\AI\Product;

use App\Ai\Agents\Product\ProductWriter;

class ProductAiService
{
    public function generate(array $data): array
    {
        $productContext = [
            'product_name'               => $data['name'] ?? null,
            'category'                   => $data['category'] ?? null,
            'sub_category'               => $data['sub_category'] ?? null,
            'brand'                      => $data['brand'] ?? null,
            'sku'                        => $data['sku'] ?? null,
            'mrp'                        => $data['mrp'] ?? null,
            'sell_price'                 => $data['sell_price'] ?? null,
            'free_shipping'              => $data['free_shipping'] ?? null,
            'existing_short_description' => $data['short_description'] ?? null,
            'existing_description'       => $data['description'] ?? null,
            'additional_instruction'     => $data['prompt'],
        ];

        $prompt = <<<PROMPT
            Generate ecommerce product content using the following
            product information and user instruction.

            PRODUCT INFORMATION:

            {$this->toJson($productContext)}

            USER INSTRUCTION:

            {$data['prompt']}

            IMPORTANT:

            - If product information is explicitly provided, use it.
            - If some product information is missing, do not invent it.
            - Follow the user's content instruction.
            - Generate only the requested structured fields.
        PROMPT;

        $response = (new ProductWriter)->prompt($prompt);

        return [
            'short_description' => $response['short_description'],
            'description'       => $response['description'],
            'meta_title'        => $response['meta_title'],
            'meta_description'  => $response['meta_description'],
            'meta_keywords'     => $response['meta_keywords'],
        ];
    }

    private function toJson(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

<?php

namespace App\Services\AI\Ecommerce;

use App\Ai\Agents\Ecommerce\EcommerceAssistant;

class EcommerceAiService
{
    public function chat(string $message): string
    {
        $response = (new EcommerceAssistant)->prompt($message);

        return (string) $response;
    }
}

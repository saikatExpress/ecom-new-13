<?php

namespace App\Services\AI\Blog;

use App\Ai\Agents\Blog\BlogWriter;

class BlogAiService
{
    public function generate(string $prompt): array
    {
        $response = (new BlogWriter)->prompt($prompt);

        return [
            'is_valid'         => $response['is_valid'] ?? false,
            'message'          => $response['message'] ?? 'Unable to determine the requested action.',
            'title'            => $response['title'] ?? '',
            'excerpt'          => $response['excerpt'] ?? '',
            'content'          => $response['content'] ?? '',
            'meta_title'       => $response['meta_title'] ?? '',
            'meta_keywords'    => $response['meta_keywords'] ?? '',
            'meta_description' => $response['meta_description'] ?? '',
        ];
    }
}

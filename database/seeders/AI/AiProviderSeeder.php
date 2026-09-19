<?php

namespace Database\Seeders\AI;

use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AiProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            [
                'name' => 'Anthropic',
                'slug' => 'anthropic',
            ],

            [
                'name' => 'Cohere',
                'slug' => 'cohere',
            ],

            [
                'name' => 'DeepSeek',
                'slug' => 'deepseek',
            ],

            [
                'name' => 'ElevenLabs',
                'slug' => 'eleven',
            ],

            [
                'name' => 'Google Gemini',
                'slug' => 'gemini',
            ],

            [
                'name' => 'Groq',
                'slug' => 'groq',
            ],

            [
                'name' => 'Jina AI',
                'slug' => 'jina',
            ],

            [
                'name' => 'Mistral AI',
                'slug' => 'mistral',
            ],

            [
                'name' => 'Ollama',
                'slug' => 'ollama',
            ],

            [
                'name' => 'OpenAI',
                'slug' => 'openai',
            ],

            [
                'name' => 'OpenAI Compatible',
                'slug' => 'openai-compatible',
            ],

            [
                'name' => 'OpenRouter',
                'slug' => 'openrouter',
            ],

            [
                'name' => 'Voyage AI',
                'slug' => 'voyageai',
            ],

            [
                'name' => 'xAI',
                'slug' => 'xai',
            ],
        ];

        DB::table('ai_providers')->update(['is_default' => false]);

        foreach ($providers as $provider) {

            DB::table('ai_providers')
            ->updateOrInsert(
                [
                    'slug' => $provider['slug'],
                ],
                [
                    'name'       => $provider['name'],
                    'img_path'   => null,
                    'is_default' => $provider['slug'] === 'gemini',
                    'status'     => StatusEnum::ACTIVE->value,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use RuntimeException;

class BaseCollection extends ResourceCollection
{
    protected array $extra = [];

    public function additionalData(array $data): static
    {
        $this->extra = $data;

        return $this;
    }

    public function toArray(Request $request): array
    {
        $resource = $this->resolveResourceClass();

        return array_merge([
            'items' => $resource::collection($this->collection),

            'pagination' => [
                'current_page' => $this->currentPage(),
                'last_page'    => $this->lastPage(),
                'per_page'     => $this->perPage(),
                'total'        => $this->total(),
                'from'         => $this->firstItem(),
                'to'           => $this->lastItem(),
                'has_more'     => $this->hasMorePages(),
            ],
        ], $this->extra);
    }

    protected function resolveResourceClass(): string
    {
        $collection = static::class;

        $resource = str_replace(
            'Collection',
            'Resource',
            $collection
        );

        if (! class_exists($resource)) {
            throw new RuntimeException("Resource class [{$resource}] not found.");
        }

        return $resource;
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
        ];
    }
}

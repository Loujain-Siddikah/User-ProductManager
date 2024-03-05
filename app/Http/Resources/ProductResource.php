<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PaginatorCollectionResource;


class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return (new PaginatorCollectionResource($this->resource))->toArray($request);
        }

        if ($this->isSingleResource()) {
            // Single resource
            return [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'image' => $this->image,
                'price' => $this->price,
                'user' => new UserResource($this->whenLoaded('user')),
            ];
        } 
    }

    private function isSingleResource(): bool
    {
         return !is_array($this->resource) || count($this->resource) === 1;
    }
    
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_data' => $this->collection,
            'pagination' => [
                "current_page" => $this->currentPage(),
                "last_page" =>  $this->lastPage(),
                "path" => $this->path(),
                "per_page" =>  $this->perPage(),
                "total" =>  $this->total(),
            ],
        ];    
    }
}

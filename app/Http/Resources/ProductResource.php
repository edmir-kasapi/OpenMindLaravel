<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'description' => $this->description,

            'price' => [
                'amount' => $this->price,
                'currency' => "USD"
            ],

            'type' => [
                'id' => $this->type->id,
                'name' => $this->type->type
            ],

            'availability' => [
                'in_stock' => $this->reserved_stock > 0
            ],

            'pictures' => $this->pictures->map(fn ($picture) => [
                'url' => asset('storage/products/' . $picture->getSrc()),
                'original_name_alt' => $picture->original_name
            ])
        ];


        //return parent::toArray($request);
    }
}

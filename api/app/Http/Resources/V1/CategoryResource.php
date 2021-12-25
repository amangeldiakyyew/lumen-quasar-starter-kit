<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $children = $this->whenLoaded('children') ?? [];
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'icon' => $this->icon,
            'icon_class' => $this->icon_class,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'sort_order' => $this->sort_order,
            'product_addable' => $this->product_addable,
            'status' => $this->status,
            'children' => CategoryResource::collection($children)
        ];
    }
}

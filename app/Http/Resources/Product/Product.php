<?php

namespace App\Http\Resources\Product;

use App\Models\Review;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'specification' => $this->specification,
            'category_id' => $this->category_id,
            'discount' => $this->discount,
            'price' => $this->price,
            'hot_deal' => $this->hot_deal,
            'new_arrival' => $this->new_arrival,
            'stock' => $this->stock,
            'sold' => $this->sold,
            'created_at' => $this->created_at,
            'images' => $this->images(),
            'category' => $this->category,
            'rating' => $this->calculateRating($this->id)
        ];
    }

    public function calculateRating($id)
    {
        $rating = Review::where('product_id', $id)->avg('stars');
        $count = Review::where('product_id', $id)->get();
        $reviews = (object) ['rating' => $rating, 'count' => count($count)];
        return $reviews;
    }
}

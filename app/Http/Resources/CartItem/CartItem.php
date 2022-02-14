<?php

namespace App\Http\Resources\CartItem;

use App\Http\Resources\Product\Product as ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItem extends JsonResource
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
            'quantity' => $this->quantity,
            'product' => $this->getProduct($this->product_id),
        ];
    }

    public function getProduct($id)
    {
        $product = Product::where('id',  $id)->first();

        return new ProductResource($product);
    }
}

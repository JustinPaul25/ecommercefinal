<?php

use App\Models\Recommendation;

if (! function_exists('createLog')) {
    function createLog($model, $inputs, $log)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($model)
            ->withProperties($inputs)
            ->log($log);
    }
}

if (! function_exists('storeRecommendation')) {
    function storeRecommendation($product, $type)
    {
        $user = auth()->user();
        Recommendation::create([
            'user_id' => $user->id,
            'brand' => $product->name,
            'category_id' => $product->category_id,
            'type' => $type
        ]);
    }
}
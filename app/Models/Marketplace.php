<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    protected $fillable = [
        'name',
    ];

    public function fee(Category $category, float $default = 0.0): float
    {
        return MarketplaceFee::where('marketplace_id', $this->id)
            ->where('category_id', $category->id)
            ->value('value') ?? $default;
    }
}

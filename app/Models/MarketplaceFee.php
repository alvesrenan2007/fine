<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Category;
use App\Models\Marketplace;

class MarketplaceFee extends Pivot
{
    protected $table = 'marketplace_fee';

    protected $casts = [
        'value' => 'decimal:4',
    ];

    // -------------------
    // | ORM Relationships
    // -------------------

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'marketplace_fee')
            ->using(MarketplaceFee::class)
            ->withPivot('value')
            ->withTimestamps();
    }

    public function marketplaces(): BelongsToMany
    {
        return $this->belongsToMany(Marketplace::class, 'marketplace_fee')
            ->using(MarketplaceFee::class)
            ->withPivot('value')
            ->withTimestamps();
    }

} // end of pivot

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    // ----------
    // | Attributes and configuration
    // ----------
    protected $fillable = [
        'name',
        'cost',
        'category_id'
    ];

    // ----------
    // | ORM Relationships
    // ----------

    /*
     * Gets the associated category
     */
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

} // end of model

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

    // ----------
    // | Attributes and configuration
    // ----------
    protected $fillable = [
        'name',
        'ncm'
    ];

    // ----------
    // | ORM Relationships
    // ----------

    /*
    * Gets all products that use this Category
    * */
    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }
}

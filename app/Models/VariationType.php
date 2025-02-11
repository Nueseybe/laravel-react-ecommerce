<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationType extends Model
{
    public function options(): HasMany
    {
        return $this->hasMany(VariationTypeOptions::class, 'variation_type_id');
    }
}

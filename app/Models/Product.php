<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku',
        'title',
        'ean',
        'uk_only',

    ];
    public function getUkOnlyAttribute(): string
    {
        // Convert the integer value of uk_only to boolean (1 => true, 0 => false)
        $booleanValue = (bool) $this->attributes['uk_only'];
        return $booleanValue ? 'True' : 'False';
    }
}

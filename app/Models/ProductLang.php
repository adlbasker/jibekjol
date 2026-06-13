<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLang extends Model
{
    use HasFactory;

    protected $table = 'products_lang';

    protected $fillable = [
        'product_id',
        'category_id',
        'slug',
        'title',
        'meta_title',
        'meta_description',
        'price',
        'price_total',
        'description',
        'characteristic',
        'lang',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}


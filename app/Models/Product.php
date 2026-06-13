<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sort_id',
        'user_id',
        'company_id',
        'barcodes',
        'count',
        'condition',
        'area',
        'capacity',
        'image',
        'images',
        'path',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function modes(): BelongsToMany
    {
        return $this->belongsToMany(Mode::class, 'product_mode');
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'product_option');
    }

    public function productsLang(): HasMany
    {
        return $this->hasMany(ProductLang::class);
    }

    public function projects()
    {
        return $this->belongsToMany('App\Models\Project', 'product_project', 'product_id', 'project_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'product_order', 'product_id', 'order_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'parent');
    }
}

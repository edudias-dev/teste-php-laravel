<?php

namespace App\Models;

use App\Exceptions\CategoryNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($issue) {
            $issue->uuid = Str::uuid(36);
        });
    }

    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'category',
        'title',
        'contents',
        'status',
        'created_at',
        'updated_at'
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function setCategoryAttribute($value): void
    {
        try {
            $this->attributes['category_id'] = Category::query()->where('name', $value)->first()->id;
        } catch (CategoryNotFoundException $exception) {
            throw new CategoryNotFoundException();
        }
    }
}

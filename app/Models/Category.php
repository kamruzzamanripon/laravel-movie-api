<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
    ];

    public function movies()
    {
        return $this->hasMany(Movie::class, 'category_id', 'id');
    }

    public function topMovies()
    {
        return $this->hasManyThrough(Movie::class, Category::class, 'id', 'category_id')
            ->orderBy('created_at', 'desc') // Assuming you want to get the latest 3 movies
            ->limit(3);
    }
}

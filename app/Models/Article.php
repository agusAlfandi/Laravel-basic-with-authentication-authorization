<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Categoriable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Article extends Model
{
  use HasFactory;

  protected $fillable = ['title', 'description'];

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  public function ratings(): MorphMany
  {
    return $this->morphMany(Rating::class, 'ratingable');
  }

  public function categories(): MorphToMany
  {
    return $this->morphToMany(
      Category::class,
      'categoriable',
      Categoriable::class
    );
  }
}

<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Category;
use App\Models\Categoriable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Blog extends Model
{
  use HasFactory;

  protected $fillable = ['title', 'description', 'author_id'];

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  public function image(): MorphOne
  {
    return $this->morphOne(Image::class, 'imageable');
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

  public function author()
  {
    return $this->belongsTo(User::class, 'author_id', 'id');
  }
}

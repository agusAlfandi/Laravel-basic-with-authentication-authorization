<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'imageable_id', 'imageable_type'];
  protected $guarded = 'id';

  public function imageable(): MorphTo
  {
    return $this->morphTo();
  }

  public function article()
  {
    return $this->belongsTo(Article::class);
  }
}

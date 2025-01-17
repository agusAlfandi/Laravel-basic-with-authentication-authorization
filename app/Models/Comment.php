<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = ['blog_id', 'comment_text'];

  function blog()
  {
    return $this->belongsTo(Blog::class);
  }

  function article()
  {
    return $this->belongsTo(Article::class);
  }
}

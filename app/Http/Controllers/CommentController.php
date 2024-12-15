<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  function store(CommnetBlogRequest $request, $blog_id)
  {
    $validated = $request->validated();

    $request['blog_id'] = $request->blog_id;
    Comment::create($validated);

    $request->session()->flash('status', 'Comment was successful added!');
    return redirect()->route('blog-detail', $blog_id);
  }

  function show()
  {
    $comment = Comment::with('blog')->get();
    return $comment;
    // return view('comment');
  }
}

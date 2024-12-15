<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
  public function index(Request $request)
  {
    $title = $request->title;
    $articles = Article::with(['ratings', 'tags', 'categories'])
      ->where('title', 'LIKE', '%' . $title . '%')
      //   ->orderBy('id', 'desc')
      ->paginate();
    // return $articles;
    return view('Article/article', compact(['articles', 'title']));
  }
}

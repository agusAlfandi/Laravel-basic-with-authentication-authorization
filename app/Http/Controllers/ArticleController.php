<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
  public function __construct(protected ArticleRepositoryInterface $repository) {}

  public function index(Request $request)
  {
    $title = $request->input('title', '');
    $articles = $this->repository->getAll($title);
    return view('Article/article', compact('articles', 'title'));
  }
}

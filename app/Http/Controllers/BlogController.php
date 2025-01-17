<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Repositories\Interfaces\BlogRepositoryInterface;

class BlogController extends Controller
{

  public function __construct(protected BlogRepositoryInterface $repository) {}

  function index(Request $request)
  {
    $title = $request->input('title', '');
    $blogs = $this->repository->getAll($title);
    return view('Blog.blog', compact('blogs', 'title'));
  }

  function add()
  {
    $tag = Tag::all();
    return view('Blog/blog-add', compact('tag'));
  }

  function create(CreateBlogRequest $request)
  {
    $validated = $request->validated();
    return $this->repository->create($validated, $request);
  }

  function show($id)
  {
    return $this->repository->show($id);
  }

  function edit(Request $request, $id)
  {
    $data = $this->repository->edit($request, $id);
    return view('/Blog/blog-edit', $data);
  }

  function update(UpdateBlogRequest $request, $id)
  {
    $validated = $request->validated();
    return $this->repository->update($validated, $id, $request);
  }

  function delete($id)
  {
    return $this->repository->delete($id);
  }

  function restore($id)
  {
    $blog = Blog::withTrashed()->findOrFail($id)->restore();
  }
}

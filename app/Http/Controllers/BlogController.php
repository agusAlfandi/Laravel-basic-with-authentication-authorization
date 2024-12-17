<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
  function index(Request $request)
  {
    $title = $request->title;

    Gate::authorize('viewAny', Blog::class);
    // $Blogs = DB::table('blogs')->where('title', 'LIKE', '%'.$title.'%')->orderBy('id', 'desc')->Paginate(8);
    $blogs = Blog::with(['tags', 'comments', 'image', 'ratings', 'categories'])
      ->where('title', 'LIKE', '%' . $title . '%')
      ->orderBy('id', 'desc')
      ->paginate(4);
    return view('Blog/blog', compact(['blogs', 'title']));
  }

  function add()
  {
    $tag = Tag::all();
    return view('Blog/blog-add', compact('tag'));
  }

  function create(CreateBlogRequest $request)
  {
    $validated = $request->validated();
    $validated['author_id'] = $request->user()->id;

    $Blogs = Blog::create($validated);
    $Blogs->tags()->attach($request->tags);

    $imageName = $request->image->hashName();

    Storage::putFileAs('images', $request->image, $imageName);

    Image::create([
      'name' => $imageName,
      'imageable_id' => $Blogs->id,
      'imageable_type' => Blog::class,
    ]);

    session()->flash('status', 'Blog was successful added!');
    return redirect()->route('blog');
  }

  function show($id)
  {
    // $blog = DB::table('blogs')->where('id',$id)->first();
    $blog = Blog::with([
      'comments' => function ($query) {
        $query->orderBy('id', 'desc');
      },
      'tags',
    ])->findOrFail($id);

    return view('/Blog/blog-detail', compact('blog'));
  }

  function edit(Request $request, $id)
  {
    $blog = Blog::with('tags')->findOrFail($id);
    $tags = Tag::all();

    Gate::authorize('update', $blog);

    return view('/Blog/blog-edit', compact(['blog', 'tags']));
  }

  function update(UpdateBlogRequest $request, $id)
  {
    $validated = $request->validated();

    $blog = Blog::with('image')->findOrFail($id);

    Gate::authorize('update', $blog);

    $blog->update($validated);
    $blog->tags()->sync($request->tags);

    if ($request->hasFile('image')) {
      $imageName = time() . '.' . $request->image->extension();
      $request->image->move(public_path('images'), $imageName);

      if ($blog->image) {
        $blog->image->update([
          'name' => $imageName,
        ]);
      } else {
        $blog->image()->create([
          'name' => $imageName,
          'imageable_id' => $blog->id,
          'imageable_type' => Blog::class,
        ]);
      }
    }

    session()->flash('status', 'Blog was successful updated!');
    return redirect()->route('/Blog/blog');
  }

  function delete($id)
  {
    // DB::table('blogs')->where('id', $id)-> delete();

    $blog = Blog::findOrFail($id);
    Gate::authorize('delete', $blog);
    $blog->delete();

    session()->flash('status', 'Blog was successful deleted!');
    return redirect()->route('blog');
  }

  function restore($id)
  {
    $blog = Blog::withTrashed()->findOrFail($id)->restore();
  }
}

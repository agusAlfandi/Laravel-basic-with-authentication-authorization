<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Image;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\BaseRepositoryInterface;


class BaseRepository implements BaseRepositoryInterface
{

    public function __construct(protected Model $model) {}

    public function getAll($title)
    {
        Gate::authorize('viewAny', Blog::class);
        return $this->model->with(['tags', 'comments', 'image', 'ratings', 'categories'])
            ->where('title', 'LIKE', '%' . $title . '%')
            ->orderBy('id', 'desc')
            ->paginate(4);
    }

    public function create($validated, $request)
    {
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

    public function show($id)
    {
        // $blog = DB::table('blogs')->where('id',$id)->first();
        $blog = Blog::with([
            'comments' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'tags',
            'image',
        ])->findOrFail($id);

        return view('/Blog/blog-detail', compact('blog'));
    }

    public function edit($request, $id)
    {
        $blog = Blog::with('tags')->findOrFail($id);
        $tags = Tag::all();

        return compact('blog', 'tags');
    }

    public function update($request, $id, $validated)
    {
        $blog = Blog::with('image')->findOrFail($id);

        Gate::authorize('update', $blog);

        $blog->update($validated);
        $blog->tags()->sync($request->tags);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::delete('images/' . $blog->image->name);
            }

            $imageName = $request->image->hashName();
            Storage::putFileAs('images', $request->image, $imageName);

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
        return redirect()->route('blog');
    }

    public function delete($id)
    {
        // DB::table('blogs')->where('id', $id)-> delete();
        $blog = Blog::findOrFail($id);
        Gate::authorize('delete', $blog);

        if ($blog->image) {
            Storage::delete('images/' . $blog->image->name);
        }
        $blog->delete();

        session()->flash('status', 'Blog was successful deleted!');
        return redirect()->route('blog');
    }
}

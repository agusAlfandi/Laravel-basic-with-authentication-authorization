<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog</title>
    @vite('resources/css/app.css')
  </head>
  <body>
    <h1 class="flex text-4xl justify-center p-5">Blog</h1>
    <div class="flex justify-center space-x-5 px-8 items-center">
      <div class="flex justify-start">
        <a href="{{ url('/blog/add') }}" class="btn btn-success">
          Add New Blog
        </a>
      </div>

      <div class="flex justify-center w-full">
        <form method="GET" class="w-full max-w-md">
          <label
            class="input input-bordered flex items-center m-auto gap-2 max-w-96"
          >
            <input
              type="text"
              name="title"
              value="{{ $title }}"
              class="grow"
              placeholder="Search Title"
            />
            <button class="btn btn-ghost" type="submit">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70"
              >
                <path
                  fill-rule="evenodd"
                  d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </label>
        </form>
      </div>

      <div class="flex justify-end">
        <a href="logout" class="btn btn-error">Logout</a>
      </div>
    </div>

    <div class="p-4">
      @if ($errors->any())
        <div class="p-5 rounded-md bg-red-300 text-red-950">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    @if (Session::has('status'))
      <p
        class="border rounded-md p-5 mt-5 mx-10 text-green-900 bg-green-300 m-auto max-w-full"
      >
        {{ Session::get('status') }}
      </p>
    @endif

    <div class="overflow-x-auto p-10">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th></th>
            <th>Image</th>
            <th>Title</th>
            <th>Author</th>
            <th>Tags</th>
            <th>Ratings</th>
            <th>Category</th>
            <th>Comment</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        @if ($blogs->count() == 0)
          <tr>
            <td colspan="3" class="text-center text-red-500">
              Data Not Found with {{ $title }} Keyword
            </td>
          </tr>
        @endif

        <tbody>
          @foreach ($blogs as $blog)
            <tr>
              <td>
                {{ ($blogs->currentPage() - 1) * $blogs->perPage() + $loop->index + 1 }}
                {{-- {{ $loop->index + 1 }} --}}
              </td>
              <td>
                @if ($blog->image && $blog->id == $blog->image->imageable_id)
                  <img
                    src="{{ env('URL_IMAGE') . $blog->image->name }}"
                    alt="logo"
                    class="w-25 h-20"
                  />
                @else
                  -
                @endif
              </td>
              <td>{{ $blog->title }}</td>

              <td>
                {{ $blog->author->name ?? '-' }}
              </td>
              <td>
                @if ($blog->tags->isEmpty())
                  -
                @else
                  @foreach ($blog->tags as $tag)
                    <div>{{ $tag->name }}</div>
                  @endforeach
                @endif
              </td>
              <td>
                @if ($blog->ratings->isEmpty())
                  -
                @else
                  {{ collect($blog->ratings->pluck('rating_value'))->avg() }}
                @endif
              </td>

              <td>
                @if ($blog->categories->isEmpty())
                  -
                @else
                  @foreach ($blog->categories as $category)
                    <div>{{ $category->name }}</div>
                  @endforeach
                @endif
              </td>

              <td>
                @foreach ($blog->comments as $comment)
                  <div>{{ $comment->comment_text }}</div>
                @endforeach
              </td>
              <td class="max-w-4xl">{{ $blog->description }}</td>

              <td class="w-auto flex justify-end gap-3">
                <a
                  href="{{ url('/blog/' . $blog->id . '/detail') }}"
                  class="btn btn-info"
                >
                  Detail
                </a>
                @can('update', $blog)
                  <a
                    href="{{ url('/blog/' . $blog->id . '/edit') }}"
                    class="btn btn-warning"
                  >
                    Edit
                  </a>
                @endcan

                @can('delete', $blog)
                  <a
                    href="{{ url('/blog/' . $blog->id . '/delete') }}"
                    class="btn btn-error"
                  >
                    Delete
                  </a>
                @endcan
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-5">
        {{ $blogs->links('vendor.pagination.daisyui') }}
      </div>
    </div>
  </body>
</html>

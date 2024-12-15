<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog</title>
    @vite('resources/css/app.css')
  </head>
  <body>
    <h1 class="flex text-4xl justify-center p-5">Article</h1>
    <div class="flex justify-center items-center">
      <div class="flex justify-center w-96">
        <a href="{{ url('/blog/add') }}" class="btn btn-success">
          Add New Article
        </a>
      </div>

      <div class="flex justify-center w-full">
        <form method="GET" class="w-full max-w-md mr-72">
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
            <th>Tags</th>
            <th>Ratings</th>
            {{-- <th>Comment</th> --}}
            <th>Category</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        @if ($articles->count() == 0)
          <tr>
            <td colspan="3" class="text-center text-red-500">
              Data Not Found with {{ $title }} Keyword
            </td>
          </tr>
        @endif

        <tbody>
          @foreach ($articles as $article)
            <tr>
              <td>
                {{ ($articles->currentPage() - 1) * $articles->perPage() + $loop->index + 1 }}
                {{-- {{ $loop->index + 1 }} --}}
              </td>
              <td>
                @if ($article->image && $article->id == $article->image->imageable_id)
                  <img
                    src="{{ env('URL_IMAGE') . $article->image->name }}"
                    alt="logo"
                    class="w-25 h-20"
                  />
                @else
                  -
                @endif
              </td>
              <td>{{ $article->title }}</td>
              <td>
                @if ($article->tags->isEmpty())
                  -
                @else
                  @foreach ($article->tags as $tag)
                    <div>{{ $tag->name }}</div>
                  @endforeach
                @endif
              </td>
              <td>
                @if ($article->ratings->isEmpty())
                  -
                @else
                  {{-- {{$article->rating}} --}}
                  {{ number_format(collect($article->ratings->pluck('rating_value'))->avg(), 1) }}
                @endif
              </td>

              <td>
                @if ($article->categories->isEmpty())
                  -
                @else
                  @foreach ($article->categories as $category)
                    <div>{{ $category->name }}</div>
                  @endforeach
                @endif
              </td>

              {{--
                <td>
                @foreach ($article->comments as $comment)
                <div>{{ $comment->comment_text }}</div>
                @endforeach
                </td>
              --}}
              <td class="max-w-4xl">{{ $article->description }}</td>
              <td class="w-auto flex justify-end gap-3">
                <a
                  href="{{ url('/blog/' . $article->id . '/detail') }}"
                  class="btn btn-info"
                >
                  Detail
                </a>
                <a
                  href="{{ url('/blog/' . $article->id . '/edit') }}"
                  class="btn btn-warning"
                >
                  Edit
                </a>
                <a
                  href="{{ url('/blog/' . $article->id . '/delete') }}"
                  class="btn btn-error"
                >
                  Delete
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="mt-5">
        {{ $articles->links('vendor.pagination.daisyui') }}
      </div>
    </div>
  </body>
</html>

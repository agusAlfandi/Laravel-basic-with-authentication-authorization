<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite('resources/css/app.css')
    <title>Blog Detail</title>
  </head>
  <body>
    <div class="flex flex-col justify-center items-center m-5">
      <h1 class="text-4xl my-10">Blog Detail</h1>
      <p>{{ $blog->title }}</p>
      <p class="text-justify">{{ $blog->description }}</p>
      <div class="divider"></div>

      <div class="flex flex-row justify-start items-center w-full gap-2">
        Tags :
        @if ($blog->tags->count() == 0)
          -
        @endif

        @foreach ($blog->tags as $tag)
          <span class="badge badge-info">{{ $tag->name }}</span>
        @endforeach
      </div>

      <div class="flex flex-col items-end w-full">
        <p>Created At: {{ $blog->created_at->format('d F Y H:i') }}</p>
        <p>
          By:
          {{ $blog->author->name ?? 'User' }}
        </p>
      </div>

      <div>
        <h1 class="text-4xl my-4 text-center">Comments</h1>
        <form
          action="{{ url('comment/' . $blog->id) }}"
          method="POST"
          class="flex flex-col justify-center w-full"
        >
          @csrf
          <textarea
            type="text"
            class="textarea textarea-bordered text-base"
            name="comment_text"
            style="resize: none"
            cols="80"
            rows="5"
            placeholder="Comment here..."
          >
          {{ old('comment_text') }}</textarea
          >

          @if ($errors->has('comment_text'))
            <div class="border rounded-lg p-5 bg-red-200 text-red-950 mt-5">
              {{ $errors->first('comment_text') }}
            </div>
          @endif

          <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>
      </div>

      <div class="divider"></div>

      <div class="flex flex-col w-full">
        <h1 class="text-4xl my-4 text-center">Comments</h1>
        @if ($blog->comments->count() == 0)
          <p class="text-center">No comments yet</p>
        @endif

        @foreach ($blog->comments as $comment)
          <div
            class="card bg-base-100 shadow-xl gap-4 mb-5 m-auto p-5 h-32 w-2/4"
          >
            <p>{{ $comment->comment_text }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </body>
</html>

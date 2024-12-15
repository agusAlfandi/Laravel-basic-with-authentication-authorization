<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite('resources/css/app.css')
    <title>Blog Edit</title>
  </head>
  <body>
    <div class="flex flex-col justify-center items-center h-screen">
      <h1 class="text-center text-4xl mb-10">Edit Blog</h1>
      <form
        action="{{ url('/blog/' . $blog->id . '/update') }}"
        method="POST"
        enctype="multipart/form-data"
        class="flex flex-col items-center gap-5"
      >
        @csrf
        @method('PATCH')
        <label class="input input-bordered flex items-center gap-2">
          Title:
          <input
            type="text"
            class="grow"
            name="title"
            value="{{ $blog->title }}"
            placeholder="Tulis disini..."
          />
        </label>
        @if ($errors->has('title'))
          <div class="border rounded-lg p-5 bg-red-200 text-red-950">
            {{ $errors->first('title') }}
          </div>
        @endif

        <textarea
          type="text"
          class="textarea textarea-bordered text-base"
          name="description"
          style="resize: none"
          cols="50"
          rows="5"
          placeholder="Description"
        >
          {{ $blog->description }}</textarea
        >

        @if ($errors->has('description'))
          <div class="border rounded-lg p-5 bg-red-200 text-red-950">
            {{ $errors->first('description') }}
          </div>
        @endif

        <label class="flex w-full">Tags:</label>

        <div class="flex flex-row gap-4">
          @foreach ($tags as $tag)
            <input
              type="checkbox"
              name="tags[]"
              value="{{ $tag->id }}"
              id="tag{{ $tag->id }}"
              class="checkbox checkbox-primary"
              @if ($blog->tags->contains($tag->id)) @checked(true) @endif
            />
            <label class="label-text" for="tag{{ $tag->id }}">
              {{ $tag->name }}
            </label>
          @endforeach
        </div>

        <div class="flex flex-col gap-4 w-full">
          <label class="input input-bordered flex items-center gap-2">
            Image:
            <input type="file" name="image" required />
          </label>
          @if ($errors->has('image'))
            <div class="border rounded-lg p-5 bg-red-200 text-red-950">
              {{ $errors->first('image') }}
            </div>
          @endif
        </div>

        <div class="w-full">
          <button class="btn btn-primary w-full">Submit</button>
        </div>
      </form>
    </div>
  </body>
</html>

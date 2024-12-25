<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Add Blog</title>
    @vite('resources/css/app.css')
  </head>
  <body>
    <div class="flex flex-col justify-center items-center h-screen">
      <h1 class="text-center text-4xl mb-10">Add New Blog</h1>

      <form
        action="{{ url('/blog/create') }}"
        method="POST"
        enctype="multipart/form-data"
        class="flex flex-col items-center gap-5"
      >
        @csrf
        <label class="input input-bordered flex items-center gap-2">
          Title:
          <input
            type="text"
            class="grow"
            name="title"
            value="{{ old('title') }}"
            placeholder="Tulis disini..."
            required
          />
        </label>

        <textarea
          type="text"
          class="textarea textarea-bordered text-base"
          name="description"
          style="resize: none"
          cols="50"
          rows="5"
          placeholder="Description"
          required
        >
          {{ old('description') }}</textarea
        >

        <label class="flex w-full justify-start">Tags:</label>

        <div class="flex flex-row gap-4">
          @foreach ($tag as $key => $tag)
            <input
              type="checkbox"
              name="tags[]"
              value="{{ $tag->id }}"
              id="tag{{ $key }}"
              class="checkbox checkbox-primary"
            />
            <label class="label-text" for="tag{{ $key }}">
              {{ $tag->name }}
            </label>
          @endforeach
        </div>

        <div class="flex flex-col gap-4 w-full">
          <label class="input input-bordered flex items-center gap-2">
            Image:
            <input type="file" name="image" required />
          </label>
        </div>
        <div class="w-full">
          <button class="btn btn-primary w-full">Submit</button>
        </div>
      </form>
    </div>

    <div class="mt-5">
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
  </body>
</html>

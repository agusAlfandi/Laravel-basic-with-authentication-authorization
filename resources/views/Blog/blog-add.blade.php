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

      {{--
        <div>
        @if ($errors->any())
        <div class="alert text-red-500 mb-4">
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
        @endif
        </div>
      --}}

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
          {{ old('description') }}</textarea
        >

        @if ($errors->has('description'))
          <div class="border rounded-lg p-5 bg-red-200 text-red-950">
            {{ $errors->first('description') }}
          </div>
        @endif

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

        {{-- @dump($tags) --}}

        <div class="flex flex-col gap-4 w-full">
          <label class="input input-bordered flex items-center gap-2">
            Image:
            {{-- <input type="number" name="{{$}}" required hidden /> --}}
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

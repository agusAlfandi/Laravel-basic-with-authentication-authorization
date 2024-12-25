<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite('resources/css/app.css')
    <title>Forgot Password</title>
  </head>
  <body class="flex flex-col justify-center items-center h-screen bg-gray-100">
    <div
      class="flex flex-col w-full max-w-md p-8 gap-8 rounded-xl bg-white shadow-lg"
    >
      <h1 class="text-2xl font-bold text-center">Forgot Password</h1>
      <p class="text-center text-gray-500">
        Enter your email address and we'll send you a link to reset your
        password
      </p>
      <form action="forgot-password" method="post" class="flex flex-col gap-8">
        @csrf
        <label class="input input-bordered flex items-center gap-2">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 16 16"
            fill="currentColor"
            class="h-4 w-4 opacity-70"
          >
            <path
              d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"
            />
            <path
              d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"
            />
          </svg>
          <input
            type="email"
            class="grow"
            placeholder="Email"
            name="email"
            required
          />
        </label>

        <button type="submit" class="btn btn-primary hover:bg-blue-700">
          Send Password Reset Link
        </button>
      </form>
    </div>

    <div class="mt-5">
    @if ($errors->any())
      <ul>
        @foreach ($errors->all() as $error)
          <li class="p-5 rounded-md bg-red-300 text-red-950">{{ $error }}</li>
        @endforeach
      </ul>
    @endif
    <div>

    <div class="mt-5">
      @if (session('status'))
        <div class="mt-5">
          <span class="p-5 rounded-md bg-green-300 text-green-950">
            {{ session('status') }}
          </span>
        </div>
      @endif
    </div>
  </body>
</html>

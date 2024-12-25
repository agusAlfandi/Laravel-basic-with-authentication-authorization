<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Verify Email</title>
    @vite('resources/css/app.css')
  </head>
  <body class="flex justify-center items-center h-screen bg-gray-100">
    <div class="card bg-stone-300 text-black w-1/2 h-52">
      <div class="flex justify-center items-center card-body gap-5">
        <h2 class="card-title">
          Hi, verification link email already send to your email
        </h2>
        <p>You can resend email verification if link gone</p>
        <form action="/email/verification-notification" method="post">
          @csrf
          <button type="submit" class="btn">Resend</button>
        </form>
      </div>
    </div>
  </body>
</html>

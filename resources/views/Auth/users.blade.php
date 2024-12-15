<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite('resources/css/app.css')
    <title>Users</title>
  </head>
  <body>
    <h1 class="text-center text-4xl my-10">Users</h1>
    <div class="overflow-x-auto p-10">
      <table class="table table-zebra">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
              <th>{{ $loop->index + 1 }}</th>
              <td>{{ $user->name }}</td>
              <td class="max-w-4xl">{{ $user->email }}</td>
              <td>{{ $user->phone->phone_num ?? '-' }}</td>
              {{--
                <td class="w-auto flex justify-end gap-3">
                <a href="{{ url('/user/'.$user->id.'/detail')}}" class="btn btn-info">
                Detail
                </a>
                <a href="{{ url('/user/'.$user->id.'/edit')}}" class="btn btn-warning">
                Edit
                </a>
                <a href="{{ url('/user/'.$user->id.'/delete')}}" class="btn btn-error">
                Delete
                </a>
                </td>
              --}}
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </body>
</html>

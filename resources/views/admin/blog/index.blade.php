<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>blogs</title>
</head>
<body>
  <a href="{{ route('admin.blogs.create') }}">Add</a>
  @if (session('success'))
    {{ session('success') }}
  @endif
  @if (session('error'))
    {{ session('error') }}
  @endif
  <table border="1" style="width: 100%">
    <thead>
      <tr>
        <th>Judul</th>
        <th>Status</th>
        <th>Dibuat tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($blogs as $blog)
        <tr>
          <td>{{ $blog->title }}</td>
          <td>{{ $blog->status }}</td>
          <td>{{ $blog->created_at->format('d F Y') }}</td>
          <td>
            <a href="{{ route('admin.blogs.edit', $blog->id) }}">Edit</a>
            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="post">
              @csrf
              @method('delete')
              <button type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {!! $blogs->links() !!}
</body>
</html>
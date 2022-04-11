<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>quote funfact</title>
</head>
<body>
  @if (session('success'))
    {{ session('success') }}
  @endif
  @if (session('error'))
    {{ session('error') }}
  @endif
  <table>
    <thead>
      <th>Judul</th>
      <th>Type</th>
      <th>Status</th>
      <th>Dibuat Tanggal</th>
      <th>Aksi</th>
    </thead>
    <tbody>
      @foreach ($quote_funfacts as $qf)
        <tr>
          <td><a href="{{ route('admin.quote-funfacts.show', $qf->id) }}">{{ $qf->title }}</a></td>
          <td>{{ $qf->type }}</td>
          <td>{{ $qf->status }}</td>
          <td>{{ $qf->created_at->format('d F Y') }}</td>
          <td>
            <a href="{{ route('admin.quote-funfacts.edit', $qf->id) }}">Edit</a>
            <form action="{{ route('admin.quote-funfacts.destroy', $qf->id) }}" method="post" class="d-inline">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-link">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
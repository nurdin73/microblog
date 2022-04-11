<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Detail</title>
</head>
<body>
  <h1>{{ $blog->title }}</h1>
  <p>{!! $blog->content !!}</p>
  <p>{{ $blog->status }}</p>
  @foreach ($blog->tags as $tag)
    <span>{{ $tag->name }}</span>,
  @endforeach

  @foreach ($blog->photos as $photo)
    <img src="{{ asset($photo->src) }}" alt="{{ $photo->src }}">
  @endforeach
</body>
</html>
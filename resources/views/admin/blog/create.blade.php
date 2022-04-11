<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>add</title>
</head>
<body>
  <form action="{{ route('admin.blogs.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="title">Judul</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}">
    <br>
    @error('title')
      {{ $message }}
    @enderror
    <br>
    <label for="status">Status</label>
    <select name="status" id="status">
      <option value="">Pilih status</option>
      <option value="published">Publish</option>
      <option value="draft">Draft</option>
    </select>
    <br>
    @error('status')
      {{ $message }}
    @enderror
    <br>
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
    <br>
    @error('content')
      {{ $message }}
    @enderror
    <br>
    <label for="tags">Tags</label>
    <select name="tags[]" id="tags" multiple>
      <option value="">Pilih tags</option>
      @foreach ($tags as $tag)
        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
      @endforeach
    </select>
    <br>
    @error('tags')
      {{ $message }}
    @enderror
    <br>
    <label for="photos">Thumbnail</label>
    <input type="file" name="photos[]" id="photos" multiple>
    <br>
    @error('photos')
      {{ $message }}
    @enderror
    <button type="submit">Submit</button>
  </form>
</body>
</html>
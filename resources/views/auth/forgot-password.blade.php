<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>reset password</title>
</head>
<body>
  <form action="{{ route('password.email') }}" method="post">
    @csrf
    <input type="email" name="email" id="email">
    @error('email')
      {{ $message }}
    @enderror
    <button type="submit">Submit</button>
  </form>
</body>
</html>
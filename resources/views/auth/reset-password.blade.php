<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>reset password</title>
</head>
<body>
  <form action="{{ route('password.update') }}" method="post">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="password" name="password" placeholder="password">
    @error('password')
      {{ $message }}
    @enderror
    <input type="password" name="password_confirmation" placeholder="password confirmation">
    @error('password_confirmation')
      {{ $message }}
    @enderror
    <button type="submit">Submit</button>
  </form>
</body>
</html>
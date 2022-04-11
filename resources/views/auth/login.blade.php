<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>login</title>
</head>
<body>
  <form action="{{ route('login') }}" method="post">
    @csrf
    <input type="text" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <button type="submit">login</button>
  </form>
</body>
</html>
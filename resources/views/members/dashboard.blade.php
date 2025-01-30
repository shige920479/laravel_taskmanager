<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>ダッシュボード画面</h1>
  <form action="{{ route('members.logout') }}" method="post">
    @csrf
    <button type="submit" style="padding: 10px 20px; background-color:blue; color:#fff">ログアウトボタン</button>
  </form>
</body>
</html>
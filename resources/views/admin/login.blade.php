<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TaskManager</title>
    <link rel="stylesheet" href="{{ asset('css/ress.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
  <body>
    <section class="login-wrapper">
      <h1>Task Manager</h1>
      <h2 id="manager-title">管理者ログイン（定期データベース操作用ページ）</h2>
      <form action="{{ route('admin.login') }}" method="post">
        @csrf
        <div class="login-box">
          <h3>Sign Up</h3>
          <ul>
            <div class="input">
              <label for="email">メールアドレス</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}"/>
              @error('email')
                <span class="flash-msg">{{ $message }}</span>
              @enderror
            </div>
            <div class="input">
              <label for="password">パスワード</label>
              <input type="password" name="password" id="password"/>
              @if ($errors->has('password'))
                <span class="flash-msg">{{ $errors->first('password') }}</span>
              @endif
            </div>
            <button type="submit">Login</button>
          </ul>
        </div>
      </form>
    </section>
  </body>
</html>
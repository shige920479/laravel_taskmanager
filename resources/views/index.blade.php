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
      <h2>チームメンバーログイン</h2>
      <div class="login-box">
        @if (session()->has('success'))
          <p style="color:cornflowerblue; text-align:center;">{{ session('success') }}</p>
        @endif
        <h3>Sign Up</h3>
        <form action="{{ route('members.login') }}" method="post">
          @csrf
          <ul>
            <div class="input">
              <label for="email">メールアドレス</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" />
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
        </form>
        <div id="to-register">
          <span>アカントが未登録ですか？</span>
          <a href="{{ route('members.create') }}" class="auth-link">→ アカウントを作成</a>
        </div>
      </div>
      <div id="to-manager">
        <a href="{{ route('manager.index')}}" class="auth-link">管理者用ログイン画面はこちら</a>
      </div>
    </section>
  </body>
</html>
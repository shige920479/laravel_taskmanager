<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TaskManager</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
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
        {{-- サクセスメッセージの表示 --}}

        <form action="{{ route('members.login') }}" method="post">
          @csrf
          <ul>
            <div class="input">
              <label for="email">メールアドレス</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" />
              {{-- @error('email')
                <span class="flash-msg">{{ $message }}</span>
              @enderror --}}
              @if($errors->has('email'))
              <span class="flash-msg">{{ $errors->first('email') }}</span>
              @endif
            </div>
            <div class="input">
              <label for="password">パスワード</label>
              <input type="password" name="password" id="password"/>
              {{-- @error('password')
                <span class="flash-msg">{{ $message }}</span>
              @enderror --}}
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
      @if ($errors->has('message'))
        <p style="color:rgb(227, 59, 98); text-align:center; margin-top:12px;">{{ $errors->first('message') }}</p>
      @endif
    </section>
  </body>
</html>
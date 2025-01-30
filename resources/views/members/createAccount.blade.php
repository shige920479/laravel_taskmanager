<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TaskManager</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
  </head>
  <body>
    <section class="login-wrapper">
      <h1>Task Manager</h1>
      <h2>アカウント作成</h2>
      <form action="{{ route('members.store')}}" method="post" class="login-box">
        @csrf
        <ul>
          <div class="input account">
              <div>
                <label for="name">ユーザーネーム</label>
                @if($errors->has('name'))
                  <span class="flash-msg">{{ $errors->first('name') }}</span>
                @endif
              </div>
              <input type="text" name="name" id="name" value="{{ old('name') }}"/>
          </div>
          <div class="input account">
            <div>
              <label for="email">メールアドレス</label>
              @if($errors->has('email'))
              <span class="flash-msg">{{ $errors->first('email') }}</span>
              @endif
            </div>
            <input type="email" name="email" id="email" value="{{ old('email') }}"/>
          </div>
          <div class="input account">
            <div>
              <label for="password">パスワード</label>
              @if($errors->has('password'))
              <span class="flash-msg">{{ $errors->first('password') }}</span>
              @endif
            </div>
            <input type="password" name="password" id="password"/>
          </div>
          <div class="input">
            <label for="password_confirmation">パスワード（確認用）</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
          </div>
          <button type="submit">アカウント登録</button>
        </ul>
        <p id="to-login"><a href="{{ route('index') }}" class="auth-link">ログイン画面に戻る</a></p>
      </form>
    </section>
  </body>
</html>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TaskManager</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
  </head>
  <body>
    <header>
      <div id="task-header" class="task-wrapper">
        <h1>タスクManager</h1>
        <div id="header-nav">
          <div><a href="{{ route('members.dashboard') }}" id="header-link">タスク一覧</a></div>
          @if (Auth::guard('users')->check())
              <div><a href="{{ route('members.callender') }}" id="header-link">タスクカレンダー</a></div>
            @elseif (Auth::guard('manager')->check())
              <div><a href="{{ route('manager.callender') }}" id="header-link">タスクカレンダー</a></div>
          @endif
          <div id="menu-icon">
            <img src="{{ asset('images/menu.png') }}" alt="">
            <div class="menu-content">
              <P>{{ $username }}さん</P>
              @if (Auth::guard('users')->check())
                <form action="{{ route('members.logout') }}" method="post">
                  @csrf
                  <button id="logout-btn" type="submit">ログアウト</button>
                </form>
              @elseif (Auth::guard('manager')->check())
                <form action="{{ route('manager.logout') }}" method="post">
                  @csrf
                  <button id="logout-btn" type="submit">ログアウト</button>
                </form>
              @endif
            </div>
          </div>
        </div>  
      </div>
    </header>

      {{ $slot }}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script> 
  </body>
</html>

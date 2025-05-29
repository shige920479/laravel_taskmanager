<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskManager</title>
    <link rel="stylesheet" href="{{ asset('css/ress.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
  <body>
    <section id="migrate-wrapper">
      <h1>migrate画面</h1>
      <h3>毎週実行</h3>
      <div id="message-box"></div>
        <div id="initial-migrate">
          <button id="refresh" type="submit" class="migrate-btn">migrate:fresh --seed</button>
          <form action="{{ route('admin.logout') }}" method="post">
            @csrf
            <button type="submit" class="migrate-btn logout">ログアウト</button>
          </form>
        </div>
    </section>
    <script>
        const refreshDb = document.getElementById('refresh'); 
        if(refreshDb) {
          refreshDb.addEventListener('click', function(event) {
              event.preventDefault();
              
              fetch("{{ route('admin.migrate') }}", {
                  method: "POST",
                  headers: {
                      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                      "Content-Type": "application/json"
                  }
              })
              .then(response => {
                if(!response.ok) {
                  throw new Error("HTTPエラー: " + response.status);
                }
                return response.json() 
              })
              .then(data => {
                document.getElementById("message-box").innerHTML = `<p style="text-align: center; color:blue; font-weight: bold">${data.message}</p>`;
              })
              .catch(error => {
                  document.getElementById("message-box").innerHTML = `<p  style="text-align: center; color:red; font-weight: bold">通信エラーが発生しました</p>`;
              });
          });
        }
    </script>
  </body>
</html>
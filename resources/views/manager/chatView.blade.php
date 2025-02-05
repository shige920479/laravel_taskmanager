<x-header>
  <x-slot name="username">{{ $user->name }}</x-slot>
      <div id="chat-wrapper">
        <h1>コメント編集</h1>
        <div id="chat-flex">
          <section id="task-side">
              <ul>
                <li>
                  <label for="priority">メンバー名</label>
                  <div>{{ $task->user_id }}</div>
                </li>
                <li>
                  <label for="priority">優先度</label>
                  <div>{{ str_repeat('☆',$task->priority) }}</div>
                </li>
                <li>
                  <label for="category">カテゴリー</label>
                  <div class="m-edit-list">{{ $task->category }}</div>
                </li>
                <li>
                  <label for="theme">タスクテーマ</label>
                  <div class="m-edit-list">{{ $task->theme }}</div>
                </li>
                <li>
                  <label for="content">タスク概略</label>
                  <div class="m-edit-list">{{ $task->content }}</div>
                </li>
                <li>
                  <label for="deadline">完了目標</label>
                  <div class="m-edit-list">{{ $task->deadline }}</div>
                </li>
              </ul>
          </section>
          <section id="chat-side">
            <label>メッセージボックス</label>
            <div id="chat-room">
              <ul id="chat-inner">
                @foreach ($chats as $chat)
                  @if ($chat->sender === 0)
                    <li class='chat me'>
                      <p class='mes'>{{$chat->comment}}</p>
                      <div class='status'>{{ $chat->created_at }}</div>
                    </li>
                  @else
                    <li class='chat you'>
                      <p class='mes'>{{$chat->comment}}</p>
                      <div class='status'>{{ $chat->created_at }}</div>
                    </li>
                  @endif
                @endforeach
              </ul>
            </div>
            <form action="{{ route('manager.sendmessage', ['id' => $task->id]) }}" method="post" id="message-box">
              @csrf
              <label>メッセージ入力
                @error('comment')
                <span class='flash-msg'>{{ $message }}</span>
                @enderror
                @if(session('success'))
                <span class="success-msg">{{ session('success') }} </span>
                @endif
              </label>
              <textarea name="comment" rows="3">{{ old('comment') }}</textarea>
                <button type="submit" class="sendmsg-btn btn">メッセージ送信</button>
            </form>
          </section>
        </div>
      </div>
</x-header>
<x-header>
<x-slot name="username">{{ $user->name }}</x-slot>

<div class="task-wrapper">
  <section id="search-section">
    <h2>タスク検索</h2>
    <form action="{{ route('manager.dashboard') }}" method="get" id="search">
      <ul id="search-flex">
        <li>
          <label for="name">メンバー名</label>
          <select name="id" id="name">
            <option value="">全て選択</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}" @if(isset($search['id']) && $search['id'] == $user->id) selected @endif>{{ $user->name }}</option>
            @endforeach
          </select>
        </li>
        <li>
          <label for="category">カテゴリー</label>
          <select name="category" id="category">
            <option value="">全て選択</option>
            @foreach ($categories as $category)
              <option value="{{ $category }}" @if(isset($search['category']) && $search['category'] === $category) selected @endif>{{ $category }}</option>
            @endforeach
          </select>
        </li>
        <li>
          <label for="theme">テーマ</label>
          <input type="text" name="theme" value="">
        </li>
        <li><button type="submit" class="search-btn btn">検索</button></li>
      </ul>
      <input type="hidden" name="sort_order" value="{{ $sort }}">
    </form>
  </section>
  <section id="m-task-list">
    <div id="title-page">
      <h2>タスク一覧</h2>
      @if (count($tasks) === 0)
        <span class='initial-msg'>タスクの登録はありません</span>
      @elseif (session('success'))
        <span class='success-msg'>{{ session('success') }}</span>
      @endif
    </div>
    <div id="sort-pagination">
      <form action="{{ route('manager.dashboard') }}" method="get" id="sort">
        <select name="sort_order" id="sort_order">
          <option value="" @if (is_null($sort)) selected @endif>新規登録順</option>
          <option value="sort_name" @if ($sort === "sort_name") selected @endif>メンバー別</option>
          <option value="sort_category" @if ($sort === "sort_category") selected @endif>カテゴリー別</option>
          <option value="sort_deadline" @if ($sort === "sort_deadline") selected @endif>完了目標順</option>
          <option value="sort_priority" @if ($sort === "sort_priority") selected @endif>優先度順</option>
        </select>
        <input type="hidden" name="id" value="@if (isset($search['id'])) {{ $search['id'] }} @endif">
        <input type="hidden" name="category" value="@if (isset($search['category'])) {{ $search['category'] }} @endif">
        <input type="hidden" name="theme" value="@if (isset($search['theme'])) {{ $search['theme'] }} @endif">
      </form>
      <div id="paginate">
        {{ $tasks->withQueryString()->links('vendor.pagination.tailwind2') }}
        {{-- {{ $tasks->withQueryString()->links() }} --}}
      </div>
    </div>
    <table>
      <thead>
        <tr>
          <th>メンバー名</th><th>優先度</th><th>カテゴリー</th><th>完了</th><th>タスクテーマ</th><th>タスク概要</th>
          <th>完了目標</th><th>残日数</th><th>送信</th><th>受信</th><th>削除</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($tasks as $task)
        <tr>
          <td>{{ $task->user->name }}</td>
          <td class="priority">{{ str_repeat('★', $task->priority) }}</td>
          <td>{{ $task->category }}</td>
          <td class="comp-icon">
            @if ($task->del_flag === 1)
            <a href="{{ route('manager.chatview', ['id' => $task->id]) }}">
              <img src="{{ asset('images/check-pink.png') }}" alt="">
            </a>
            @elseif ($task->del_flag === 2)
            <a href="{{ route('manager.chatview', ['id' => $task->id]) }}">
              <img src="{{ asset('images/turnback-green.png') }}" alt="">
            </a>
            @endif
          </td>
          <td class="edit-link"><a href="{{ route('manager.chatview', ['id' => $task->id]) }}">{{ $task->theme }}</a></td>
          <td>{{ $task->content }}</td>
          <td>{{ date('m月d日', strtotime($task->deadline)) }}</td>
          <td class="diff-date" data-days="{{ MyLib::diffDate($task->deadline) }}">{{ MyLib::diffDate($task->deadline) }}</td>
          <td class="msg-icon">
            @if ($task->msg_flag !== 0 && $task->mg_to_mem === 1)
              <a href="{{ route('manager.chatview', ['id' => $task->id]) }}">
                <img src="{{ asset('images/hikoki.png') }}">
              </a>
            @elseif ($task->msg_flag !== 0 && $task->mg_to_mem === 0)
              <a href="{{ route('manager.chatview', ['id' => $task->id]) }}">
                <img src="{{ asset('images/checkbox.png') }}" alt="">
              </a>
            @endif
          </td>
          <td class="msg-icon">
            @if ($task->msg_flag !== 0 && $task->mem_to_mg === 1)
              <a href="{{ route('manager.chatview', ['id' => $task->id]) }}">
                <img src="{{ asset('images/midoku.png') }}">
              </a>
            @elseif ($task->msg_flag !== 0 && $task->mem_to_mg === 2)
              <a href="{{ route('manager.chatview', ['id' => $task->id]) }}">
                <img src="{{ asset('images/kidoku.png') }}" alt="">
              </a>
            @endif
          </td>
          <td>
            @if ($task->del_flag === 1)
              <form action="{{ route('manager.delete', ['id' => $task->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="del-btn btn">削除</button>
              </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>
</div>

</x-header>
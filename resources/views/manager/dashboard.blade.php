<x-header>
<x-slot name="username">{{ $user->name }}</x-slot>

<div class="task-wrapper">
  <section id="search-section">
    <h2>タスク検索</h2>
    <form action="{{ route('manager.dashboard') }}" method="get" id="search">
      <ul id="search-flex">
        <li>
          <label for="name">メンバー名</label>
          <select name="name" id="name">
            <option value="">全て選択</option>
            @foreach ($members as $member)
              <option value="{{ $member->id }}">{{ $member->name }}</option>
            @endforeach
          </select>
        </li>
        <li>
          <label for="category">カテゴリー</label>
          <select name="category" id="category">
            <option value="">全て選択</option>
            @foreach ($categories as $category)
              <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
          </select>
        </li>
        <li>
          <label for="theme">テーマ</label>
          <input type="text" name="theme" value="">
        </li>
        <li><button type="submit" class="search-btn btn">検索</button></li>
      </ul>
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
          <option value="sort_name" @if ($sort === "sort_name") selected @endif></option>
          <option value="sort_category" @if ($sort === "sort_category") selected @endif>カテゴリー別</option>
          <option value="sort_deadline" @if ($sort === "sort_deadline") selected @endif>完了目標順</option>
          <option value="sort_priority" @if ($sort === "sort_priority") selected @endif>優先度順</option>
        </select>
      </form>
      <div id="paginate">
        {{ $tasks->onEachSide(5)->links('vendor.pagination.tailwind2') }}
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
          <td>{{ $task->user_id }}</td> {{-- 後で差し替え 名前表示へ --}}
          <td class="priority">{{ str_repeat('☆', $task->priority) }}</td>
          <td>{{ $task->category }}</td>
          <td class="comp-icon">
            @if ($task->del_flag === 1)
              <img src="{{ asset('images/check-pink.png') }}" alt="">
            @elseif ($task->del_flag === 2)
              <img src="{{ asset('images/turnback-green.png') }}" alt="">
            @endif
          </td>
          <td><a href="{{ route('members.edit', ['id' => $task->id]) }}">{{ $task->theme }}</a></td>
          <td>{{ $task->content }}</td>
          <td>{{ date('m月d日', strtotime($task->deadline)) }}</td>
          <td class="diff-date" data-days="{{ diffDate($task->deadline) }}">{{ diffDate($task->deadline) }}</td>
          {{-- <td class="diff-date" data-days="{{  }}<?= diffDate($task['deadline']) ?>"><?= diffDate($task['deadline'])."日" ?></td> --}}
          {{-- <td class="diff-date" data-days="<?= diffDate($task['deadline']) ?>"><?= diffDate($task['deadline'])."日" ?></td> --}}
          <td class="msg-icon">
            @if ($task->msg_flag !== 0 && $task->mg_to_mem === 1)
              <img src="{{ asset('images/hikoki.png') }}">
            @elseif ($task->msg_flag !== 0 && $task->mg_to_mem === 0)
              <img src="{{ asset('images/checkbox.png') }}" alt="">
            @endif
          </td>
          <td class="msg-icon">
            @if ($task->msg_flag !== 0 && $task->mem_to_mg === 1)
              <img src="{{ asset('images/midoku.png') }}">
            @elseif ($task->msg_flag !== 0 && $task->mem_to_mg === 2)
              <img src="{{ asset('images/kidoku.png') }}" alt="">
            @endif
          </td>
          <td>
            @if ($task->del_flag === 1)
              <form action="" method="post"> {{-- route(****, ['id' => $task->id])  --}}
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
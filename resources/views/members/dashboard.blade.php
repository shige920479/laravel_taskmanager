<x-header>
  <x-slot name="username">{{ $user->name }}</x-slot>

    <div class="task-wrapper">
      <section id="new-task">
        <h2>新規タスク登録</h2>
        <form action="{{ route('members.store') }}" method="post">
          @csrf
          <ul>
            <li>
              <label for="priority">優先度</label>
              <select name="priority">
                <option value="">選択</option>
                <option value="3" @if (old('priority') === "3") selected @endif>高</option>
                <option value="2" @if (old('priority') === "2") selected @endif>中</option>
                <option value="1" @if (old('priority') === "1") selected @endif>低</option>
              </select>
               @error('priority')
                <span class='flash-msg'>{{ $message }}</span>
               @enderror
            </li>
            <li>
              <label for="catgory">カテゴリー</label>
              <input type="text" name="category" list="categories" placeholder="テキスト入力または選択" autocomplete="off"
              value="{{ old('category') }}"/>
              <datalist id="categories">
                @foreach ($categories as $category)
                  <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
              </datalist>
                @error('category')
                  <span class='flash-msg'>{{ $message }}</span>
                @enderror
            </li>
            <li>
              <label for="theme">テーマ</label>
              <input type="text" name="theme" id="theme" value="{{ old('theme') }}"/>
                @error('theme')
                  <span class="flash-msg">{{ $message }}</span>
                @enderror
            </li>
            <li>
              <label for="content">タスク概略</label>
              <input type="text" name="content" id="content" value=" {{ old('content') }}"/>
                @error('content')
                <span class='flash-msg'>{{ $message }}</span>
                @enderror
            </li>
            <li>
              <label for="deadline">目標完了日</label>
              <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"/>
                @error('deadline')
                  <span class='flash-msg'>{{ $message }}</span>
                @enderror
            </li>
            <li>
              <button type="submit" id="regist-btn" class="btn">登録</button>
            </li>
          </ul>
          <input type="hidden" name="user_id" value="{{ $user->id }}">
        </form>
      </section>
      <section id="task-list">
        <div id="title-page">
          <h2>タスク一覧</h2>
            @if(count($tasks) ===0)
              <span class='initial-msg'>タスクの登録はありません</span>
            @elseif(session('success'))
              <span class='success-msg'>{{ session('success') }}</span>
            @endif
        </div>
        <div id="sort-pagination">
          <form action="{{ route('members.dashboard') }}" method="get" id="sort">
            <select name="sort_order" id="sort_order">
              <option value="" @if (is_null($sort)) selected @endif>新規登録順</option>
              <option value="sort_deadline" @if ($sort === 'sort_deadline') selected @endif>目標完了日順</option>
              <option value="sort_category" @if ($sort === 'sort_category') selected @endif>カテゴリー別</option>
              <option value="sort_priority" @if ($sort === 'sort_priority') selected @endif>優先度順</option>
            </select>
            <input type="hidden" name="mode" value="index">
          </form>
          {{-- <ul id="paginate"> --}}
          <div>
            {{ $tasks->withQueryString()->links('vendor.pagination.tailwind2') }}
          </div>
          {{-- </ul> --}}
        </div>
        <table>
          <thead>
            <tr>
              <th>優先度</th><th>カテゴリー</th><th></th><th>テーマ</th><th>タスク概略</th><th>目標完了日</th><th>送信</th><th>受信</th><th>完了</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tasks as $task)
            <tr>
              <td class="priority">{{ str_repeat('☆', $task->priority) }}</td>
              <td>{{ $task->category }}</td>
              <td class="comp-icon">
                @if ($task->del_flag === 2)
                  <img src="{{ asset('images/turnback-green.png') }}" alt="">
                @endif
              </td>
              <td class="edit-link"><a href="{{ route('members.chatview', ['id' => $task->id])}}">{{ $task->theme }}</a></td>
              <td>{{ $task->content }}</td>
              <td>{{ date('m月d日', strtotime($task->deadline)) }}</td>
              <td class="msg-icon">
                @if ($task->msg_flag !== 0 && $task->mem_to_mg === 1)  {{-- routeは後で修正 --}}
                  <a href="{{ route('members.chatview', ['id' => $task->id]) }}">
                    <img src="{{ asset('images/hikoki.png') }}" alt="">
                  </a>
                @elseif ($task->msg_flag !== 0 && $task->mem_to_mg === 2)
                <a href="{{ route('members.chatview', ['id' => $task->id]) }}">
                  <img src="{{ asset('images/checkbox.png') }}" alt="">
                </a>
                @endif
              </td>
              <td class="msg-icon">
                @if ($task->msg_flag !== 0 && $task->mg_to_mem === 1)  {{-- routeは後で修正 --}}
                  <a href="{{ route('members.chatview', ['id' => $task->id]) }}">
                    <img src="{{ asset('images/midoku.png') }}" alt="">
                  </a>
                @elseif ($task->msg_flag !== 0 && $task->mg_to_mem === 0)
                  <a href="{{ route('members.chatview', ['id' => $task->id]) }}">
                    <img src="{{ asset('images/kidoku.png') }}" alt="">
                  </a>
                @endif
              </td>
              <td>
                <form action="※※※※※※※※※※※※" method="post"> {{-- 後で設定 --}}
                  @csrf
                  <button type="submit" class="comp-btn btn">完了</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </section>
    </div>
</x-header>
@include('layouts.memberHeader')

    <div class="task-wrapper">
      <section id="new-task">
        <h2>新規タスク登録</h2>
        <form action="*****************" method="post">
          @csrf
          <ul>
            <li>
              <label for="priority">優先度</label>
              <select name="priority">
                <option value="">選択</option>
                <option value="3" @if (old('priority') === 3) selected @endif>高</option>
                <option value="2" @if (old('priority') === 2) selected @endif>中</option>
                <option value="1" @if (old('priority') === 1) selected @endif>低</option>
              </select>
              {{-- エラーメッセージ --}}
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
              {{-- <?php echo isset($flash_array['category']) ? "<span class='flash-msg'>{$flash_array['category']}</span>" : '' ?> --}}
            </li>
            <li>
              <label for="theme">テーマ</label>
              <input type="text" name="theme" id="theme" value="{{ old('theme') }}"/>
              {{-- <?php echo isset($flash_array['theme']) ? "<span class='flash-msg'>{$flash_array['theme']}</span>" : '' ?> --}}
            </li>
            <li>
              <label for="content">タスク概略</label>
              <input type="text" name="content" id="content" value=" {{ old('content') }}" />
              {{-- <?php echo isset($flash_array['content']) ? "<span class='flash-msg'>{$flash_array['content']}</span>" : '' ?> --}}
            </li>
            <li>
              <label for="deadline">目標完了日</label>
              <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"/>
              {{-- <?php echo isset($flash_array['deadline']) ? "<span class='flash-msg'>{$flash_array['deadline']}</span>" : '' ?> --}}
            </li>
            <li>
              <button type="submit" id="regist-btn" class="btn">登録</button>
            </li>
          </ul>
        </form>
      </section>
      <section id="task-list">
        <div id="title-page">
          <h2>タスク一覧</h2>
            {{-- <?php if(!empty($_SESSION['del_msg'])) :?>
            <?php echo "<span class='del_msg'>{$_SESSION['del_msg']}</span>"; ?>
            <?php unset($_SESSION['del_msg'])?>
            <?php endif ;?> --}}
            {{-- <?php echo empty($tasks) ? "<span class='initial-msg'>未完了のタスクはありません</span>": '';?> --}}
        </div>
        <div id="sort-pagination">
          <form action="" method="get" id="sort">
            <select name="sort_order" id="sort_order">
              <option value="">新規登録順</option>
              <option value="sort_deadline" <?php echo isset($request['sort_order']) && $request['sort_order'] === 'sort_deadline' ? 'selected': "";?>>目標完了日順</option>
              <option value="sort_category" <?php echo isset($request['sort_order']) && $request['sort_order'] === 'sort_category' ? 'selected': "";?>>カテゴリー別</option>
              <option value="sort_priority" <?php echo isset($request['sort_order']) && $request['sort_order'] === 'sort_priority' ? 'selected': "";?>>優先度順</option>
            </select>
            <input type="hidden" name="mode" value="index">
          </form>
          <ul id="paginate">{{ $tasks->links() }}</ul>
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
              {{-- <td class="priority"><?php echo str_repeat('☆', $task['priority'])?></td> --}}
              <td>{{ $task->category }}</td>
              <td class="comp-icon">
                @if ($task->del_flag === 2)
                  <img src="{{ asset('images/turnback-green.png') }}" alt="">
                @endif
              </td>
              {{-- <td class="comp-icon"><?php echo $task['del_flag'] === 2 ? '<img src="' . PATH . 'images/turnback-green.png">' : "" ;?></td> --}}
              <td class="edit-link"><a href="※※※※※※※※※※※">{{ $task->theme }}</a></td>
              {{-- <td class="edit-link"><?php echo "<a href='?mode=edit&id={$task['id']}'>{$task['theme']}</a>" ?></td> --}}
              <td>{{ $task->content }}</td>
              {{-- <td><?php echo $task['content'] ?></td> --}}
              <td>{{ date('m月d日', strtotime($task->deadline)) }}</td>
              {{-- <td><?php echo date('m月d日', strtotime($task['deadline']))  ?></td> --}}
              <td class="msg-icon">
              {{-- アイコン表示は後で対応する --}}
                {{-- <?php echo setSendIcon($task['msg_flag'], $task['mem_to_mg'], $task['id']) ?> --}}
              </td>
              <td class="msg-icon">
                {{-- <?php echo setRecieveIcon($task['msg_flag'], $task['mg_to_mem'], $task['id']) ?> --}}
              </td>
              <td>
                <form action="※※※※※※※※※※※※" method="post">
                  @csrf
                  <button type="submit" class="comp-btn btn">完了</button>
                  {{-- <input type="hidden" name="mode" value="soft_del">
                  <input type="hidden" name="id" value="<?php echo h($task['id']) ?>">
                  <input type="hidden" name="token" value="<?php echo h($token); ?>"> --}}
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </section>
    </div>
  </body>
</html>

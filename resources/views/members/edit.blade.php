@include('components.header')

<div class="wrapper edit-wrapper">
      <h1>編集ページ</h1>
      <div id="to_index"><a href="{{ route('members.dashboard') }}">一覧へ戻る</a></div>

      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>            
        @endforeach
      @endif

      <section>
        <form action="{{ route('members.update', ['id' => $task->id]) }}" method="post">
          @csrf
          @method('PUT')
          <ul id="edit-table">
            <li>
              <label for="priority">優先度</label>
              {{-- <?php echo isset($flash_array['priority']) ? "<span class='flash-msg'>{$flash_array['priority']}</span>" : '' ?> --}}
              <select name="priority" id="priority">
                  <option value="3" @if ($task->priority === 3) selected @endif>高</option>
                  <option value="2" @if ($task->priority === 2) selected @endif>中</option>
                  <option value="1" @if ($task->priority === 1) selected @endif>低</option>
              </select>
            </li>
            <li>
              <label for="category">カテゴリー</label>
              {{-- <?php echo isset($flash_array['category']) ? "<span class='flash-msg'>{$flash_array['category']}</span>" : '' ?> --}}
              <input type="text" name="category" list="categories" value="{{ old('category', $task->category) }}" autocomplete="off" />
              <datalist id="categories">
              @foreach ($categories as $category)
                <option value="{{ $category }}"></option>
              @endforeach
              </datalist>
            </li>
            <li>
              <label for="theme">タイトル</label>
              {{-- <?php echo isset($flash_array['theme']) ? "<span class='flash-msg'>{$flash_array['theme']}</span>" : '' ?> --}}
              <input type="text" name="theme" id="theme" value="{{ old('theme', $task->theme) }}"/>
            </li>
            <li>
              <label for="content">タスク概略</label>
              {{-- <?php echo isset($flash_array['content']) ? "<span class='flash-msg'>{$flash_array['content']}</span>" : '' ?> --}}
              <textarea type="text" name="content" id="content">{{ old('content', $task->content) }}</textarea>
            </li>
            <li>
              <label for="deadline">目標完了日</label>
              {{-- <?php echo isset($flash_array['deadline']) ? "<span class='flash-msg'>{$flash_array['deadline']}</span>" : '' ?> --}}
              <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline) }}"/>
            </li>
            </li>
            <li>
              <button type="submit" id="regist-btn" class="btn">登録</button>
            </li>
          </ul>
        </form> 
      </section>
    </div>
@include('components.footer')
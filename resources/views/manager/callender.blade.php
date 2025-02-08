<x-header>
  <x-slot name="username">{{ $user->name }}</x-slot>

  <div class="calender-wrapper">
    <div id="month">
      <a href="{{ route('manager.callender', ['week' => $prev_week]) }}">前週</a>
      <p>{{ $start_date->format('m/d') }} ～ {{ $end_date->format('m/d') }}</p>
      <a href="{{ route('manager.callender', ['week' => $next_week])}}">次週</a>
    </div>
    
    <table id="taskboard">
      <div id="color-exp"><span>完了タスク</span></div>
      <thead>
        <tr>
          <th>カテゴリー</th>
          @for ($date = $start_date->copy(); $date <= $end_date->copy(); $date->addDay())
          <th>{{ $date->isoFormat('MM/DD (ddd)') }}</th>
          @endfor
        </tr>
      <tbody>
        @foreach ($categories as $category)
          <tr>
            <td><div class="category">{{ $category }}</div></td>
            @for ($date = $start_date->copy(); $date <= $end_date; $date->addDay())
              <td>
                @foreach ($tasks as $task)
                  @if ($task->category === $category && $task->deadline === $date->format('Y-m-d'))
                    <a href="{{ route('manager.chatview',['id' => $task->id]) }}">
                      @if ($task->del_flag === 1)
                      <div class="box comp-color">
                      @else
                      <div class="box {{ 'mem-color' . $task->user_id }} ">
                      @endif
                        <p>{{ $task->user->name }}</p>
                        <div class="theme-flex">
                          <span class="theme">{{ $task->theme }}</span>
                          <span class="star">{{ str_repeat('★', intval($task->priority)) }}</span>
                        </div>
                        <p>{{ $task->content }}</p>
                      </div>
                    </a>
                  @endif
                @endforeach
              </td>
            @endfor
          </tr>
        @endforeach
        </tbody>
      </thead>
    </table>
  </div>
</x-header>
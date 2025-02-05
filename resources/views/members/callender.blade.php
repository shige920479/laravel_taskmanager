<x-header>
  <x-slot name="username">{{ $user->name }}</x-slot>

  <div class="calender-wrapper">
    <div id="month">
      <a href="{{ route('members.callender', ['week' => $prev_week]) }}">前週</a>
      <p>{{ $start_date->format('m/d') }} ～ {{ $end_date->format('m/d') }}</p>
      <a href="{{ route('members.callender', ['week' => $next_week])}}">次週</a>
    </div>
    
    <table id="taskboard">
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
                      <div class="box">
                        <div class="theme-flex">
                          <span class="theme">{{ $task->theme }}</span>
                          <span class="star">{{ str_repeat('★', intval($task->priority)) }}</span>
                        </div>
                        <p>{{ $task->content }}</p>
                      </div>
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
<ul class="item" data-id="{{$bid->id}}">
  <label>
    <span>Current top bid: {{ $bid->valuee }} <br> By user: {{ $bid->getUserName($bid->id)}}</span>
  </label>
</ul>

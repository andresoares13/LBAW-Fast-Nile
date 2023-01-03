<div class="dropdown-item header-noti" id="notiRow.{{$i+1}}"><a  href="{{ url('/auction/'.$notification->idauction) }}">{{$i+1}} | {{$notification->messages}} | </a>
<i  id="notification.{{$i+1}}" class="fa-regular fa-eye">
    <input type="hidden" name="id" value={{$notification->id}}>
    <span class="tooltiptext">Mark as read</span>    
</i>
</div>




@if (!$notification->viewed)
<tr class="unseen">
@else
<tr>
@endif
@if (isset($pageNr))    
<td>{{($i+($pageNr-1)*20)+1}} </td>
@else
<td>{{$i+1}} </td>
@endif
<td><a href="{{ url('/auction/'.$notification->idauction) }}">{{ $notification->getAuctionName($notification->idauction) }}</a></td>
<td>{{$notification->messages}}</td>
<input type="hidden" name="id" value={{$notification->id}}>


</tr>
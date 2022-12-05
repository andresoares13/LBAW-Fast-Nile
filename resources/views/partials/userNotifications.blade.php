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
@if ($notification->idauction != null)
<td><a href="{{ url('/auction/'.$notification->idauction) }}">{{ $notification->getAuctionName($notification->idauction) }}</a></td>
@else
@php
$auction = substr($notification->messages, strpos($notification->messages, "- ") + 1);
@endphp
<td>{{$auction}}</td>
@endif
<td>{{$notification->messages}}</td>
<input type="hidden" name="id" value={{$notification->id}}>


</tr>
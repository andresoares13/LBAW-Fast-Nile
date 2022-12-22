@if ($bid->iduser == null)
<tr style="text-decoration: line-through;">
@else
<tr>
@endif
@if (isset($pageNr))    
<td>{{($i+($pageNr-1)*20)+1}} </td>
@else
<td>{{$i+1}} </td>
@endif
<td>{{ $bid->valuee }} €</td>
@if (isset($pageNr))
<td><a href="/auction/{{$bid->idauction}}">{{$bid->getAuction($bid->idauction)[0]->title }}</a></td>
@else
@if ($bid->iduser != null)
<td><a href="/profile/{{$bid->iduser}}">{{ $bid->getUserName($bid->iduser)}}</a></td>
@else
<td><a >Anonymous</a> </td>
@endif
@endif
</tr>

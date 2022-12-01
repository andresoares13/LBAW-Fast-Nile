<tr>
@if (isset($pageNr))    
<td>{{($i+($pageNr-1)*20)+1}} </td>
@else
<td>{{$i+1}} </td>
@endif
<td>{{ $bid->valuee }} €</td>
@if (isset($pageNr))
<td><a href="/auction/{{$bid->idauction}}">{{$bid->getAuction($bid->idauction)[0]->title }}</a></td>
@else
<td><a href="/users/{{$bid->iduser}}">{{ $bid->getUserName($bid->iduser)}}</a></td>
@endif
</tr>
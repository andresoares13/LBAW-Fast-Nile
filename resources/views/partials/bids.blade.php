<tr><td>{{$i+1}} </td><td>{{ $bid->valuee }}</td>
@if (isset($pageNr))
<td><a href="/auction/{{$bid->idauction}}">{{$bid->getAuction($bid->idauction)[0]->title }}</a></td>
@else
<td>{{ $bid->getUserName($bid->iduser)}}</td>
@endif
</tr>
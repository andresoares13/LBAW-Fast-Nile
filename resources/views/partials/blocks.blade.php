<tr>
@if (isset($pageNr))    
<td>{{($i+($pageNr-1)*20)+1}} </td>
@else
<td>{{$i+1}} </td>
@endif
<td><a href="{{url('/profile/'.$block->iduser)}}">{{$block->getUsername($block->iduser)}}</a></td>
<td><a href="{{url('/profileAdmin/'.$block->idadmin)}}">{{$block->getUsernameAdmin($block->idadmin)}}</a></td>
<td>{{$block->justification}}</td>
</tr>
@if($editable)
<a class="btn btn-xs btn-warning" href="{{ route('admin.prints.exodologia.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
@endif
<a class="btn btn-xs btn-success" href="{{ route('admin.prints.exodologia.print', $id)}}" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Φύλλο Αγώνα σε PDF"></i> </a>
@if($editable)
<a class="btn btn-xs btn-danger"  href="{{ route('admin.prints.exodologia.delete', $id)}}" name="delete" deactivate><i class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Διαγραφή"></i></a>
@endif
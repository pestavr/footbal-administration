
		<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.move.transfer.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Επισκόπηση"></i></span>
		<!--<a class="btn btn-xs btn-warning" href="{{ route('admin.move.transfer.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Επεξεργασία Μεταγραφής"></i> </a>-->
		<a class="btn btn-xs btn-danger"  href="{{ route('admin.move.transfer.delete', $id)}}" name="deactivate" deactivate><i class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Διαγραφή"></i></a>
	
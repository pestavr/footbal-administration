@if ($locked)
	<span class="btn btn-xs btn-primary " load="#"><i class="fa fa-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="Κλειδωμένο"></i></span>
@else
	<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.competition.cup.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Εμφάνιση Στοιχείων"></i></span>
	@if($program)
		<a class="btn btn-xs btn-success" href="{{ route('admin.competition.cup.program', $id)}}"><i class="fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Πρόγραμμα Ομίλου"></i> </a>
	@endif
		<a class="btn btn-xs btn-warning" href="{{ route('admin.competition.cup.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Επεξεργασία Ομίλου"></i> </a>
	@if($delete && $flexible && $kind==1)
		<a class="btn btn-xs btn-warning" href="{{ route('admin.competition.cup.changeTeams', $id)}}"><i class="glyphicon glyphicon-refresh" data-toggle="tooltip" data-placement="top" title="" data-original-title="Αλλαγή ομάδων"></i> </a>
	@endif
	@if($draw)
		<a class="btn btn-xs btn-info" href="{{ route('admin.competition.cup.draw', $id)}}"><i class="glyphicon glyphicon-random" data-toggle="tooltip" data-placement="top" title="" data-original-title="Κλήρωση Ομίλου"></i> </a>
	@endif
	@if(config('settings.tieBrake')=='UEFA' && $kind==1)
		<a class="btn btn-xs btn-primary"  href="{{ route('admin.competition.cup.tiebrake', $id)}}"><i class="fa fa-list-ul" data-toggle="tooltip" data-placement="top" title="" data-original-title="Διαχείριση Ισοβαθμιών"></i></a>
	@endif
	@if ($condition=='deactivate')
		<a class="btn btn-xs btn-success"  href="{{ route('admin.competition.cup.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
		@else
		<a class="btn btn-xs btn-danger"  href="{{ route('admin.competition.cup.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
	@endif
	@if($delete)
		<a class="btn btn-xs btn-danger"  href="{{ route('admin.competition.cup.delete', $id)}}" name="deactivate" deactivate><i class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Διαγραφή"></i></a>
	@endif
@endif
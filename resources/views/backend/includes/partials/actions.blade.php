@if (isset($page))
	@if ($page== 'referees') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.referees.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.referees.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-success" href="{{ route('admin.file.referees.program', $id)}}"><i class="fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Πρόγραμμα Διαιτητή"></i> </a>
				<a class="btn btn-xs btn-primary" href="{{ route('admin.file.referees.refStats', $id)}}"><i class="glyphicon glyphicon-stats" data-toggle="tooltip" data-placement="top" title="" data-original-title="Στατιστικά Διαιτητή"></i> </a>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.referees.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.referees.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
	@if ($page== 'ref_observer') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.ref_observer.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.ref_observer.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-success" href="{{ route('admin.file.ref_observer.program', $id)}}"><i class="fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Πρόγραμμα Παρατηρητή Διαιτησίας"></i> </a>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.ref_observer.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.ref_observer.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>

			@endif
		
	@endif
	@if ($page== 'court') 
		
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.court.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.court.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-success" href="{{ route('admin.file.court.program', $id)}}"><i class="fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Προγραμματισμένες αναμετρήσεις"></i> </a>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.court.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-info" href="{{ route('admin.file.court.map', $id)}}"><i class="glyphicon glyphicon-map-marker" data-toggle="tooltip" data-placement="top" title="" data-original-title="Επεξεργασία χάρτη"></i> </a>
			@if(config('settings.cities'))
				<a class="btn btn-xs btn-primary"  href="{{ route('admin.file.court.cities', $id)}}" name="cities"><i class="glyphicon glyphicon-road" data-toggle="tooltip" data-placement="top" title="" data-original-title="Επεξεργασία Αποστάσεων"></i></a>
			@endif
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.court.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
	@if ($page== 'observer') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.observer.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.observer.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-success" href="{{ route('admin.file.observer.program', $id)}}"><i class="fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Πρόγραμμα Παρατηρητή"></i> </a>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.observer.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.observer.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
	@if ($page== 'doctor') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.doctor.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.doctor.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-success" href="{{ route('admin.file.doctor.program', $id)}}"><i class="fa fa-futbol-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Πρόγραμμα Υγειονομικού"></i> </a>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.doctor.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.doctor.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
	@if ($page== 'players') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.players.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.players.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.players.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.players.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
	@if ($page== 'team') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.team.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.team.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.team.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Επεξεργασία"></i> </a>
				<a class="btn btn-xs btn-success" href="{{ route('admin.file.players.team', $id)}}"><i  class="fa fa-users" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ποδοσφαιριστές"></i> </a>
				<a class="btn btn-xs btn-danger" href="{{ route('admin.file.teamsAccountable.team', $id)}}"><i  class="fa fa-user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Υπόλογοι Σωματείου"></i> </a>
				<a class="btn btn-xs btn-primary" href="{{ route('admin.file.team.ds', $id)}}"><i  class="fa fa-black-tie" data-toggle="tooltip" data-placement="top" title="" data-original-title="Διοικητικό Συμβούλιο"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.team.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
	@if ($page== 'teamsAccountable') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.file.teamsAccountable.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.file.teamsAccountable.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></span>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.file.teamsAccountable.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.file.teamsAccountable.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
	@if ($page== 'educations') 
			
			@if ($condition=='deactivate')
				<a class="btn btn-xs btn-success"  href="{{ route('admin.education.referees.update', $refereeEducation)}}?mode=activate" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
			@else
				<a class="modal-trigger btn btn-xs btn-primary " href="{{ route('admin.education.referees.show', $refereeEducation)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show"></i></a>
				<a class="btn btn-xs btn-warning" href="{{ route('admin.education.referees.edit', $refereeEducation)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i> </a>
				<a class="btn btn-xs btn-danger"  href="{{ route('admin.education.referees.update', $refereeEducation)}}?mode=deactivate" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
			@endif
		
	@endif
@endif
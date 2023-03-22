@if($page=='flexible')
	@if ($locked)
		<span class="btn btn-xs btn-primary " load="#"><i class="fa fa-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="Κλειδωμένο"></i></span>
	@else
		@if ($match_stats)
			@if ($edit)
					<a class="btn btn-xs btn-warning" href="{{route('admin.program.match.edit', $id) }}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="Επεξεργασία Δεδομένων Φύλλου Αγώνα" data-original-title="Επεξεργασία Δεδομένων Φύλλου Αγώνα"></i> </a>
					<a class="btn btn-xs btn-danger" href="{{route('admin.program.match.delete', $id) }}" name="delete"><i class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="Διαγραφή Δεδομένων Φύλλου Αγώνα" data-original-title="Διαγραφή Δεδομένων Φύλλου Αγώνα"></i> </a>
			@else
					<a class="btn btn-xs btn-success" href="{{route('admin.program.match.insert', $id) }}"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="Εισαγωγή Δεδομένων Φύλλου Αγώνα" data-original-title="Εισαγωγή Δεδομένων Φύλλου Αγώνα"></i> </a>
					<a class="btn btn-xs btn-danger" href="{{route('admin.program.program.resetMatch', $id) }}"><i class="glyphicon glyphicon-repeat" data-toggle="tooltip" data-placement="top" title="Επαναφορά αναμέτρησης" data-original-title="Εισαγωγή Δεδομένων Φύλλου Αγώνα"></i> </a>
			@endif
			@if (config('settings.insertLink'))
				<span class="link-modal-trigger btn btn-xs btn-primary " load="{{ route('admin.program.program.insertLink', $id)}}"><i class="glyphicon glyphicon-link" data-toggle="tooltip" data-placement="top" title="Εισαγωγή link Αναμέτρησης" data-original-title="Εισαγωγή link Αναμέτρησης"></i></span>
			@endif
		@else
			@if($postponed)
				<a class="btn btn-xs btn-success" href="{{ route('admin.program.program.depostpone', $id)}}"><i class="glyphicon glyphicon-erase" data-toggle="tooltip" data-placement="top" title="Αναίρεση Αναβολής" data-original-title="Αναβολή"></i> </a>
			@else	
				<a class="btn btn-xs btn-danger" href="{{ route('admin.program.program.postpone', $id)}}"><i class="glyphicon glyphicon-hourglass" data-toggle="tooltip" data-placement="top" title="Αναβολή" data-original-title="Αναβολή"></i> </a>
			@endif
			@if ($flexible)
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.program.program.changeTeams', $id)}}"><i class="fa fa-exchange" data-toggle="tooltip" data-placement="top" title="Αλλαγή ομάδων αναμέτρησης" data-original-title="Αλλαγή ομάδων αναμέτρησης"></i></span>
			@endif
			
		@endif
	@endif

@endif
@if($page=='matches')
<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.program.program.score', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Καταχώρηση Σκορ"></i></span>
@endif
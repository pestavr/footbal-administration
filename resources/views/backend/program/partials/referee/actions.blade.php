@if ($locked)
	<span class="btn btn-xs btn-primary " load="#"><i class="fa fa-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="Κλειδωμένο"></i></span>
	@if(config('settings.grades'))
		@if($grades)
			<span class="grades-modal-trigger btn btn-xs btn-primary " load="{{ route('admin.orismos.referee.grades.matchGrades', $id)}}"><i class="glyphicon glyphicon-check" data-toggle="tooltip" data-placement="top" title="" data-original-title="Βαθμοί Παρατηρητή Διαιτησίας"></i></span>
		@endif
	@endif
@else
	@if($accepted && $accepted->accepted == 0 && $accepted->refused == 0)
	<span>Αποδέχεσαι τον Ορισμό</span><br/>
	<a class="btn btn-xs btn-success" href="{{ route('admin.orismos.referee.accept', $id)}}"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="" data-original-title="Αποδέχομαι"></i> </a>
	<a class="btn btn-xs btn-danger" href="{{ route('admin.orismos.referee.refuse', $id)}}"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="" data-original-title="Δεν αποδέχομαι"></i> </a>
	@else
		<a class="btn btn-xs btn-warning" href="{{ route('admin.prints.exodologia.print', $id)}}" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Εξοδολόγιο σε PDF"></i> </a>
		@if(config('settings.matchsheets'))
			@if ($category >= 50)
				<a class="btn btn-xs btn-success" href="{{ route('admin.prints.matchsheets.print', $id)}}" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Φύλλο Αγώνα σε PDF"></i> </a>
			@else
				<a class="btn btn-xs btn-success" href="{{ route('admin.prints.matchsheets.printMen', $id)}}" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Φύλλο Αγώνα σε PDF"></i> </a>
			@endif
		@endif
		@if(config('settings.insertScore'))
			@if(!$readonly && $insertScore)
				<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.program.program.score', $id)}}"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Καταχώρηση Σκορ"></i></span>
			@endif
		@endif
		@if(config('settings.grades'))
			@if($grades)
				<span class="grades-modal-trigger btn btn-xs btn-primary " load="{{ route('admin.orismos.referee.grades.matchGrades', $id)}}"><i class="glyphicon glyphicon-check" data-toggle="tooltip" data-placement="top" title="" data-original-title="Βαθμοί Παρατηρητή Διαιτησίας"></i></span>
			@endif
		@endif
		@if(config('settings.insertMatchsheets'))
			@if(!$edit && $readonly && !$postponed)
				<a class="btn btn-xs btn-success" href="{{route('admin.program.match.insert', $id) }}"><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="Εισαγωγή Δεδομένων Φύλλου Αγώνα" data-original-title="Εισαγωγή Δεδομένων Φύλλου Αγώνα"></i> </a>
			@endif
		@endif
	@endif
@endif

		
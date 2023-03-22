@if ($readonly || $postponed)
	<span class="btn btn-xs btn-primary " load="#"><i class="fa fa-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="Κλειδωμένο"></i></span>
@else
	@if($start)
		@if($end)
			<a class="btn btn-xs btn-primary" href="{{route('admin.live.live.match', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="Επεξεργασία Αναμέτρησης" data-original-title="Επεξεργασία Αναμέτρησης"></i> </a>
		@else
			<a class="btn btn-xs btn-success" href="{{route('admin.live.live.match', $id)}}"><i class="glyphicon glyphicon-plus" data-toggle="tooltip" data-placement="top" title="Επεξεργασία Αναμέτρησης" data-original-title="Επεξεργασία Αναμέτρησης"></i> </a>
			<a class="btn btn-xs btn-success" href="{{route('admin.live.live.endA', $id)}}"><i class="fa fa-flag-checkered" data-toggle="tooltip" data-placement="top" title="Λήξη Α' Ημιχρόνου" data-original-title="Λήξη Α' Ημιχρόνου"></i> </a>
			<a class="btn btn-xs btn-success" href="{{route('admin.live.live.startB', $id)}}"><i class="fa fa-flag" data-toggle="tooltip" data-placement="top" title="Έναρξη Β' Ημιχρόνου" data-original-title="Έναρξη Β' Ημιχρόνου"></i> </a>
			<a class="btn btn-xs btn-danger" href="{{route('admin.live.live.end', $id)}}"><i class="fa fa-flag-checkered" data-toggle="tooltip" data-placement="top" title="Λήξη Αναμέτρησης" data-original-title="Λήξη Αναμέτρησης"></i> </a>
		@endif
	@else
		<a class="btn btn-xs btn-success" href="{{route('admin.live.live.start', $id)}}"><i class="fa fa-flag" data-toggle="tooltip" data-placement="top" title="Έναρξη Αναμέτρησης" data-original-title="Έναρξη Αναμέτρησης"></i> </a>
	@endif
@endif


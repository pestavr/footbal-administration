
@if ($locked)
	<span class="btn btn-xs btn-primary " load="#"><i class="fa fa-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="Κλειδωμένο"></i></span>
@else
	

	@if(config('settings.live_from_observer'))
		@if(!$readonly)
			<a class="modal-trigger btn btn-xs btn-primary {{ $canStart && $insertScore ? '' : 'disabled' }}" href="{{ route('admin.live.live.matchObserver', $id)}}" role="button" {{ $canStart && $insertScore ? '' : 'aria-disabled=true' }}><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Live Αναμέτρησης"></i></a> 
		@endif
	@endif
@endif

		
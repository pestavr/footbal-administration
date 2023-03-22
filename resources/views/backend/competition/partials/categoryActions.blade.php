<span class="modal-trigger btn btn-xs btn-primary " load="{{ route('admin.competition.category.show', $id)}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="Εμφάνιση Στοιχείων"></i></span>
<a class="btn btn-xs btn-warning" href="{{ route('admin.competition.category.edit', $id)}}"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Επεξεργασία Κατηγορίας"></i> </a>
@if ($flexible)
	<a class="btn btn-xs btn-info"  href="{{ route('admin.competition.category.makeNotFlexible', $id)}}"><i class="glyphicon glyphicon-resize-small" data-toggle="tooltip" data-placement="top" title="" data-original-title="Οι αγωνιστικές της κατηγορίας θα είναι αμετάβλητες"></i></a>
	@else
	<a class="btn btn-xs btn-info"  href="{{ route('admin.competition.category.makeFlexible', $id)}}"><i class="glyphicon glyphicon-resize-full" data-toggle="tooltip" data-placement="top" title="" data-original-title="Οι αγωνιστικές της κατηγορίας θα μπορούν να μεταβληθούν"></i></a>
@endif
@if ($condition=='deactivate')
	<a class="btn btn-xs btn-success"  href="{{ route('admin.competition.category.activate', $id)}}" activate><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate"></i></a>
	@else
	<a class="btn btn-xs btn-danger"  href="{{ route('admin.competition.category.deactivate', $id)}}" name="deactivate" deactivate><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
@endif
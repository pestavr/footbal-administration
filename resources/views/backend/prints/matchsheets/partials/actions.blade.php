@if ($category >= 50)
	<a class="btn btn-xs btn-success" href="{{ route('admin.prints.matchsheets.print', $id)}}" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Φύλλο Αγώνα σε PDF"></i> </a>
@else
	<a class="btn btn-xs btn-success" href="{{ route('admin.prints.matchsheets.printMen', $id)}}" target="_blank"><i class="fa fa-file-pdf-o" data-toggle="tooltip" data-placement="top" title="" data-original-title="Φύλλο Αγώνα σε PDF"></i> </a>
@endif
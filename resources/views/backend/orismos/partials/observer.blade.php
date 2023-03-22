{{Form::text('observer-'.$match, $lastname.' '.$firstname , ['class'=>'form-control observer', 'rel'=> 'observer', 'match'=> $match, 'readonly'=> $readonly])}}
{{Form::hidden('doc_id-'.$match, $id , ['class'=>'form-control ', 'id'=>'doc_id-'.$match])}}
<div id="info-{{ $match }}">
	<table class="table table-responsive">
		<tr>
			
			<th>
				<center><i class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="top" title="" data-original-title="Έχει ορισθεί σε άλλη αναμέτρηση την ίδια ημέρα και ώρα "></i></center>
			</th>
			<th>
				<center><i class="glyphicon glyphicon-floppy-save" data-toggle="tooltip" data-placement="top" title="" data-original-title="Αποθηκεύθηκε "></i></center>
			</th>
		</tr>
		</tr>
		<tr>
			<td id="sameTime-{{ $match }}-observer"></td>
			<td id="save-{{ $match }}-observer"></td>
		</tr>
		

</div>
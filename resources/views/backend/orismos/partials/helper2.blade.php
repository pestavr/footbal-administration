@if(isset($grades))
{{Form::text('helper2-grade-'.$match, $h2_grades , ['class'=>'form-control', 'rel'=> 'helper2', 'match'=> $match, 'readonly'=> $readonly])}}
<small id="gcehelp" class="form-text text-muted">{{$lastname}} {{$firstname}}</small>	
@else
	{{Form::text('helper2-'.$match, $lastname.' '.$firstname , ['class'=>'form-control referee','rel'=> 'helper2', 'match'=> $match, 'readonly'=> $readonly])}}
	{{Form::hidden('h2_id-'.$match, $id , ['class'=>'form-control ', 'id'=>'h2_id-'.$match])}}

	<div class="info-{{ $match }}">
		<table class="table table-responsive">
			<tr>
				<th>
					<center><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top"  data-original-title="Έχει πάιξει την ίδια ομάδα τις τελευταίες {{ config('settings.ref_days') }}  ημέρες"></i></center>
				</th>
				<th>
					<center><i class="fa fa-user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Έχει κώλυμα την συγκεκριμένη ημέρα και ώρα"></i></center>
				</th>
				<th>
					<center><i class="glyphicon glyphicon-star-empty" data-toggle="tooltip" data-placement="top" title="" data-original-title="Έχει κώλυμα με μία από τις ομάδες"></i></center>
				</th>
				<th>
					<center><i class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="top" title="" data-original-title="Έχει ορισθεί σε άλλη αναμέτρηση την ίδια ημέρα και ώρα "></i></center>
				</th>
				<th>
					<center><i class="glyphicon glyphicon-floppy-save" data-toggle="tooltip" data-placement="top" title="" data-original-title="Αποθηκεύθηκε "></i></center>
				</th>
			</tr>
			</tr>
			<tr>
				<td id="ref_days-{{ $match }}-helper2">{!! $ref_days !!}</td>
				<td id="refBlock-{{ $match }}-helper2">{!! $refBlock !!}</td>
				<td id="teamBlock-{{ $match }}-helper2">{!! $teamBlock !!}</td>
				<td id="sameTime-{{ $match }}-helper2">{!! $sameTime !!}</td>
				<td id="save-{{ $match }}-helper2"></td>
			</tr>
			<tr>
				<td>
					<center><i class="fa fa-users" data-toggle="tooltip" data-placement="top"  data-original-title="Γηπεδούχος" style="color: #0000FF"></i></center>
				</td>
				<td id="team1-{{ $match }}-helper2">
				</td >
				<td>
					<center><i class="fa fa-users" data-toggle="tooltip"  data-placement="top"  data-original-title="Φιλοξενούμενος" style="color: #FF0000"></i></center>
				</td>
				<td id="team2-{{ $match }}-helper2"  colspan="2">
				</td>
			</tr>
		</table>
		<table class="table table-responsive">
			<tr>
				<td>
						Ειδοποιήθηκε
				</td>
				<td>
						Αποδέχθηκε
				</td>
			</tr>
			<tr>
				<td>
						{!! ($accepted) ? ($accepted->notified == 1) ? '<span style="color:#00AA88">Ναι</span>' : '<span style="color:#FF0000">Όχι</span>' : '<span style="color:#FF0000">Όχι</span>' !!}
				</td>
				<td>
						{!! ($accepted) ? 
							($accepted->accepted == 0 && $accepted->refused == 0) ? 
								'Δεν έχει απαντήσει' : 
								(($accepted->accepted == 1) ? 
									'<span style="color:#00AA88">Αποδέχθηκε</span>' : 
									'<span style="color:#FF0000">Αρνήθηκε</span>') 
							: 'Δεν μπορεί να απαντήσει' !!}
				</td>
			</tr>
		</table>
	</div>
@endif
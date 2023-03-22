<h5>Αναμέτρηση</h5>
<hr/>
<select class="form-control" name="match_id" id="match_id">
	@foreach($matches as $match)
		<option value="{{ $match->match_id }}"> {{ \Carbon\Carbon::parse($match->date_time)->format('d/m/Y')}} | {{$match->team1}} - {{$match->team2}}</option>
	@endforeach
</select>
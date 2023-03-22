<h5>Ιστορικό Ποινών Ποδοσφαιριστή</h5>
<hr/>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Ημερομηνία</th><th>Ομάδα</th><th>Ποινή(Αγωνιστικές| Χρηματική)</th><th>Αιτιολογία</th>
		</tr>
	</thead>
	@foreach($penalties as $penalty)
	<tr><td>{{\Carbon\Carbon::parse($penalty->infliction_date)->format('d/m/Y')}}</td><td>{{ $penalty->team_name }}</td><td>{{ $penalty->match_days }}</td><td>{{ $penalty->reason }}</td></tr>
	@endforeach
</table>
@foreach ($transfers as $transfer)
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Δελτίο</strong>: {{ $transfer->player_id }}</li>
  <li ><strong>Ονοματεπώνυμο</strong>: {{ $transfer->name }}</li>
  <li ><strong>Ομάδα Προέλευσης</strong>: {{ $transfer->team_from }}</li>
  <li ><strong>Ομάδα Προορισμού</strong>: {{ $transfer->team_to }}</li>
  <li ><strong>Ημερομηνία</strong>: {{ \Carbon\Carbon::parse($transfer->date)->format('d/m/Y') }}</li>
 </ul>
<hr>
<hr>
@endforeach

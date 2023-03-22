@foreach ($players as $player)
<h4> <i>{{$player->Surname}} {{$player->Name}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Όνομα Πατέρσ</strong>: {{ $player->F_name }}</li>
  <li ><strong>Ημερομηνία Γέννησης</strong>: {{ \Carbon\Carbon::parse($player->Birthdate)->format('d/m/Y') }}</li>
  <li ><strong>Χώρα</strong>: {{ $player->country }}</li>
  <?php
  	switch ($player->position) {
  		case '1':
  			$pos='Τερματοφύλακας';
  			break;
  		case '2':
  			$pos='Αμυντικός';
  			break;
  		case '3':
  			$pos='Μέσος';
  			break;
  		case '4':
  			$pos='Επιθετικός';
  			break;
  		default:
  			$pos='Μη καταχωρημένη';
  			break;
  	}
  ?>
  <li ><strong>Θέση</strong>: {{ $pos }}</li>
  <li ><strong>Ομάδα</strong>: {{ $player->team }}</li>
 </ul>

<hr>
@endforeach
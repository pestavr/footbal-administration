@foreach ($players as $player)
<h4> {{$player->player_id}}- <i>{{$player->pl_surname}} {{$player->pl_name}}</i>  του {{$player->F_name}} </h4>
<h5>Στοιχεία Ποινής</h5>
<ul class="list-unstyled">
  <li ><strong>Ομάδα</strong>: {{ $player->team_name }}</li>
  <li ><strong>Αναμέτρηση</strong>: {{ $player->onoma_ghp }} - {{ $player->onoma_fil }}</li>
  <li ><strong>Ημερομηνία Επιβολής</strong>: {{ \Carbon\Carbon::parse($player->infliction_date)->format('d/m/Y') }}</li>
  <li ><strong>Αριθμός Απόφασης</strong>: {{ $player->decision_num }}</li>
  <li ><strong>Αιτιολογία</strong>: {{ $player->reason }}</li>
  <li ><strong>Χρηματική Ποινή</strong>: {{ (($player->fine>0)?$player->fine.'&euro;':'-') }} </li>
  <?php
    switch ($player->kind_of_days) {
      case '1':
        $pos='Αγωνιστικές';
        break;
      case '2':
        $pos='Ημερολογιακές Ημέρες';
        break;
      case '3':
        $pos='Μήνες';
        break;
      default:
        $pos='Αγωνιστικές';
        break;
    }
  ?>
  <li ><strong>Αγωνιστικές</strong>: {{ $player->match_days }} {{ $pos }} </li>
  <li ><strong>Υπόλοιπο</strong>: {{ $player->remain }}</li>
 </ul>

<hr>
@endforeach
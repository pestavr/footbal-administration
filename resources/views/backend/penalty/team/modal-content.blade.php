@foreach ($teams as $team)
<h4> <i>{{$team->team_name}} </h4>
<h5>Στοιχεία Ποινής</h5>
<ul class="list-unstyled">
  <li ><strong>Αναμέτρηση</strong>: {{ $team->onoma_ghp }} - {{ $team->onoma_fil }}</li>
  <li ><strong>Ημερομηνία Επιβολής</strong>: {{ \Carbon\Carbon::parse($team->infliction_date)->format('d/m/Y') }}</li>
  <li ><strong>Αριθμός Απόφασης</strong>: {{ $team->decision_num }}</li>
  <li ><strong>Αιτιολογία</strong>: {{ $team->reason }}</li>
  <li ><strong>Χρηματική Ποινή</strong>: {{ (($team->fine>0)?$team->fine.'&euro;':'-') }} </li>
  <li ><strong>Αγωνιστικές</strong>: {{ $team->match_days }} </li>
  <li ><strong>Αφαίρεση Βαθμών</strong>: {{ $team->pointsoff }}  </li>
  <li ><strong>Περιγραφή</strong>: {{ $team->description }}  </li>
  <li ><strong>Υπόλοιπο</strong>: {{ $team->remain }}</li>
 </ul>

@endforeach
@foreach ($teamsAccountable as $teamsAccount)
<h4> <i>{{$teamsAccount->Surname}} {{$teamsAccount->Name}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Όνομα Πατέρσ</strong>: {{ $teamsAccount->FName }}</li>
  <li ><strong>Διεύθυνση</strong>: {{ $teamsAccount->Address }}, {{ $teamsAccount->Tk }}, {{ $teamsAccount->Region }}, {{ $teamsAccount->City }}</li>
  <li ><strong>Σταθερό Τηλέφωνο</strong>: {{ $teamsAccount->Tel }}</li>
  <li ><strong>Κινητό Τηλέφωνο</strong>: {{ $teamsAccount->Mobile }}</li>
  <li ><strong>e-mail</strong>: {{ $teamsAccount->email }}</li>
  <li ><strong>Ομάδα</strong>: {{ $teamsAccount->team }}</li>
 </ul>

<hr>
@endforeach
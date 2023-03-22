@foreach ($referees as $referee)
<h4> <i>{{$referee->Lastname}} {{$referee->Firstname}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Όνομα Πατέρσ</strong>: {{ $referee->Fname }}</li>
  <li ><strong>Διεύθυνση</strong>: {{ $referee->ddress }}</li>
  <li ><strong>ΤΚ</strong>: {{ $referee->tk }}</li>
  <li ><strong>Πόλη</strong>: {{ $referee->city }}</li>
  <li ><strong>Τηλέφωνο</strong>: {{ $referee->tel }}</li>
  <li ><strong>email</strong>: {{ $referee->email }}</li>
 </ul>

<hr>
@endforeach
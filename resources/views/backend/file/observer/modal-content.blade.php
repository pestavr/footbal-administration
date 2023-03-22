@foreach ($observers as $observer)
<h4> <i>{{$observer->waLastName}} {{$observer->waFirstName}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Όνομα Πατέρσ</strong>: {{ $observer->Fname }}</li>
  <li ><strong>Διεύθυνση</strong>: {{ $observer->Address }}</li>
  <li ><strong>ΤΚ</strong>: {{ $observer->tk }}</li>
  <li ><strong>Πόλη</strong>: {{ $observer->city }}</li>
  <li ><strong>Τηλέφωνο</strong>: {{ $observer->waTel }}</li>
  <li ><strong>email</strong>: {{ $observer->email }}</li>
 </ul>

<hr>
@endforeach
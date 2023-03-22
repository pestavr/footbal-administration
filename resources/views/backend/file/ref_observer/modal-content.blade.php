@foreach ($ref_observers as $ref_observer)
<h4> <i>{{$ref_observer->waLastName}} {{$ref_observer->waFirstName}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Όνομα Πατέρσ</strong>: {{ $ref_observer->Fname }}</li>
  <li ><strong>Διεύθυνση</strong>: {{ $ref_observer->Address }}</li>
  <li ><strong>ΤΚ</strong>: {{ $ref_observer->tk }}</li>
  <li ><strong>Πόλη</strong>: {{ $ref_observer->city }}</li>
  <li ><strong>Τηλέφωνο</strong>: {{ $ref_observer->waTel }}</li>
  <li ><strong>email</strong>: {{ $ref_observer->email }}</li>
 </ul>

<hr>
@endforeach
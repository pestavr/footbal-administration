@foreach ($doctors as $doctor)
<h4> <i>{{$doctor->docLastName}} {{$doctor->docFirstName}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Όνομα Πατέρσ</strong>: {{ $doctor->Fname }}</li>
  <li ><strong>Διεύθυνση</strong>: {{ $doctor->Address }}</li>
  <li ><strong>ΤΚ</strong>: {{ $doctor->tk }}</li>
  <li ><strong>Πόλη</strong>: {{ $doctor->city }}</li>
  <li ><strong>Τηλέφωνο</strong>: {{ $doctor->docTel }}</li>
  <li ><strong>email</strong>: {{ $doctor->email }}</li>
 </ul>

<hr>
@endforeach
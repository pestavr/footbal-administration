@foreach ($courts as $court)
<h4> <i>{{$court->eps_name}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Είδος Τεραίν</strong>: {{ $court->fild }}</li>
  <li ><strong>Αποδυτήρια</strong>: {{ $court->apoditiria }}</li>
  <li ><strong>Θέσεις</strong>: {{ $court->Sheets }}</li>
  <li ><strong>Διεύθυνση</strong>: {{ $court->address }}</li>
  <li ><strong>ΤΚ</strong>: {{ $court->tk }}</li>
  <li ><strong>Περιοχή</strong>: {{ $court->region }}</li>
  <li ><strong>Πόλη</strong>: {{ $court->town }}</li>
  <li ><strong>Τηλέφωνο</strong>: {{ $court->tel }}</li>
  <li ><strong>Φαξ</strong>: {{ $court->fax }}</li>
  <li ><strong>email</strong>: {{ $court->email }}</li>
  <li ><strong>Υπεύθυνος Γηπέδου</strong>: {{ $court->administrator }}</li>
  <li ><strong>Τηλέφωνο Υπεύυνου</strong>: {{ $court->tel_admin }}</li>
 </ul>

<hr>
@endforeach
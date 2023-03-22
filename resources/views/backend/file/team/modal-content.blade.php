@foreach ($teams as $team)
<h4> <i>{{$team->onoma_web}} </i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Ηλικιακή Κατηγορία</strong>: {{ $team->Title }}- {{ $team->Age_Level_Title}}</li>
  <li ><strong>Έτος Ίδρυσης</strong>: {{ $team->etos_idrisis }}</li>
  <li ><strong>ΑΜ ΕΠΟ</strong>: {{ $team->aa_epo }}</li>
  <li ><strong>ΑΦΜ</strong>: {{ $team->afm }}</li>
  <li ><strong>Έδρα</strong>: {{ $team->edra }}</li>
  <li ><strong>Εναλλακτική Έδρα</strong>: {{ $team->edra2 }}</li>
  <li ><strong>Διεύθυνση</strong>: {{ $team->address }}</li>
  <li ><strong>ΤΚ</strong>: {{ $team->tk }}</li>
  <li ><strong>Περιοχή</strong>: {{ $team->region }}</li>
  <li ><strong>Πόλη</strong>: {{ $team->city }}</li>
  <li ><strong>Τηλέφωνο</strong>: {{ $team->tel }}</li>
  <li ><strong>Κινητό Τηλέφωνο</strong>: {{ $team->smstel }}</li>
  <li ><strong>Fax</strong>: {{ $team->fax }}</li>
  <li ><strong>Site</strong>: {{ $team->site }}</li>
  <li ><strong>email</strong>: {{ $team->email }}</li>
 </ul>
<hr>
<hr>
@endforeach
@foreach ($category as $cat)
<h5> Αγωνίζεται: {{ $cat->categories }}</h5>
@endforeach
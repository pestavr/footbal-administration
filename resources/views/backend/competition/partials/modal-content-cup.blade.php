@foreach ($groups as $group)
<h4> <i>{{$group->Lastname}}</i> </h4>
<h5>Στοιχεία Ομίλου</h5>
<ul class="list-unstyled">
  <li ><strong>Αγωνιστική Περίοδος</strong>: {{ $group->period }}</li>
  <li ><strong>Όνομα</strong>: {{ $group->omilos }}</li>
  <li ><strong>Κατηγορία</strong>: {{ $group->category }}</li>
  <li ><strong>Φάση</strong>: {{ $group->phases }}</li>
  <li ><strong>Πλήθος Ομάδων</strong>: {{ $group->omades }}</li>
  <li ><strong>Ομάδες που Περνάνε στην Επόμενη Φάση</strong>: {{ $group->qualify }}</li>

 </ul>
@endforeach
<hr>
<h5>Ομάδες Ομίλου</h5>
@foreach ($teams as $team)
<ul class="list-unstyled">
	<li>{{$team->teamName}}- Κλειδάριθμος: {{$team->drawKey}}</li>
</ul>
@endforeach

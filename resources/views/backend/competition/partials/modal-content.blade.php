@foreach ($groups as $group)
<h4> <i>{{$group->Lastname}}</i> </h4>
<h5>Στοιχεία Ομίλου</h5>
<ul class="list-unstyled">
  <li ><strong>Αγωνιστική Περίοδος</strong>: {{ $group->period }}</li>
  <li ><strong>Όνομα</strong>: {{ $group->omilos }}</li>
  <li ><strong>Κατηγορία</strong>: {{ $group->category }}</li>
  <li ><strong>Ηλικιακή Κατηγορία</strong>: {{ $group->ageLevelTitle }}</li>
  <li ><strong>Πλήθος Ομάδων</strong>: {{ $group->omades }}</li>
  <li ><strong>Ομάδες που Προβιβάζονται</strong>: {{ $group->qualify }}</li>
  <li ><strong>Ομάδες που Υποβιβάζονται</strong>: {{ $group->relegation }}</li>
  <li ><strong>Ομάδες που παίζουν Μπαράζ Προβιβασμού</strong>: {{ $group->q_mparaz }}</li>
  <li ><strong>Ομάδες που παίζουν Μπαράζ Υποβιβασμού</strong>: {{ $group->r_mparaz }}</li>
  <li ><strong>Κανονική Περίοδος</strong>: {{ ($group->regular_season==0)?'Όχι':'Ναι' }}</li>
 </ul>
@endforeach
<hr>
<h5>Ομάδες Ομίλου</h5>
@foreach ($teams as $team)
<ul class="list-unstyled">
	<li>{{$team->teamName}}- Κλειδάριθμος: {{$team->drawKey}}</li>
</ul>
@endforeach

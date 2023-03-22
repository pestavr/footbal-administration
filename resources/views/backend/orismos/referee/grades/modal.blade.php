@foreach ($matches as $match)
<h4>Αναμέτρηση</h4>
<h4>Κατηγορία: {{$match->omilos}}</h4>
<h4>Ημερομηνία: {{date('d-m-Y', strtotime($match->date_time)) }}- Ώρα: {{date('H:i', strtotime($match->date_time))}}- Γήπεδο: {{$match->field}}</h4>
<h4></h4>

<h4>Βαθμολογία</h4>
<ul class="list-unstyled">
  <li ><strong>Διαιτητής ({{$match->ref_last_name}})</strong>: {{ $match->ref_grades }}</li>
  <li ><strong>Πρώτος Βοηθός({{ $match->h1_last_name}})</strong>: {{ $match->h1_grades }}</li>
  <li ><strong>Δεύτερος Βοηθός({{$match->h2_last_name}})</strong>: {{ $match->h2_grades }}</li>
 </ul>

<hr>
@endforeach
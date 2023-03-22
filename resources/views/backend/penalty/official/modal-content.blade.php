@foreach ($officials as $official)
<h4> <i>{{$official->name}} ({{$official->title}} )</h4>
<h5>Στοιχεία Ποινής</h5>
<ul class="list-unstyled">
  <li ><strong>Αναμέτρηση</strong>: {{ $official->onoma_ghp }} - {{ $official->onoma_fil }}</li>
  <li ><strong>Ημερομηνία Επιβολής</strong>: {{ \Carbon\Carbon::parse($official->infliction_date)->format('d/m/Y') }}</li>
  <li ><strong>Αριθμός Απόφασης</strong>: {{ $official->decision_num }}</li>
  <li ><strong>Αιτιολογία</strong>: {{ $official->reason }}</li>
  <li ><strong>Χρηματική Ποινή</strong>: {{ (($official->fine>0)?$official->fine.'&euro;':'-') }} </li>
   <?php
    switch ($official->kind_of_days) {
      case '1':
        $pos='Αγωνιστικές';
        break;
      case '2':
        $pos='Ημερολογιακές Ημέρες';
        break;
      case '3':
        $pos='Μήνες';
        break;
      default:
        $pos='Αγωνιστικές';
        break;
    }
  ?>
  <li ><strong>Αγωνιστικές</strong>: {{ $official->match_days }} </li>
  <li ><strong>Περιγραφή</strong>: {{ $official->description }}  </li>
  <li ><strong>Υπόλοιπο</strong>: {{ $official->remain }}</li>
 </ul>

@endforeach
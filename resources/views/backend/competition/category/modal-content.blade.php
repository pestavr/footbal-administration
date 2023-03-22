@foreach ($category as $cat)
<h4> <i>{{$cat->category}}</i> </h4>
<h5>Βασικά Στοιχεία</h5>
<ul class="list-unstyled">
  <li ><strong>Ηλικιακό Επίπεδο</strong>: {{ $cat->age_level }}</li>	
  <li ><strong>Αμοιβή Διαιτητή</strong>: {{ $cat->ref }}€</li>
  <li ><strong>Αμοιβή Βοηθών</strong>: {{ $cat->hel }}€</li>
  <li ><strong>Ημεραργίες Διαιτητών</strong>: {{ $cat->ref_daily }}€</li>
  <li ><strong>Ημεραργίες Βοηθών</strong>: {{ $cat->hel_daily }}€</li>
  <li ><strong>Χιλιομετρική Αποζημίωση Διαιτητών και Βοηθών</strong>: {{ $cat->eu_Km }}€/χλμ</li>
  <li ><strong>Αμοιβή Παρατηρητών</strong>: {{ $cat->wa_ma }}€</li>
  <li ><strong>Χιλιομετρική Αποζημίωση Παρατηρητών</strong>: {{ $cat->waEuKm }}€/χλμ</li>
  <li ><strong>Αμοιβή Παρατηρητών Διαιτησίας</strong>: {{ $cat->wa_ref }}€</li>
  <li ><strong>Χιλιομετρική Αποζημίωση Παρατηρητών Διαιτησίας</strong>: {{ $cat->waRefEuKm }}€/χλμ</li>
  <li ><strong>Αμοιβή Υγειονομικού Προσωπικού</strong>: {{ $cat->doc }}€</li>
  <li ><strong>Χιλιομετρική Αποζημίωση Υγειονομικού Προσωπικού</strong>: {{ $cat->docEuKm }}€/χλμ</li>
 </ul>

<hr>
@endforeach
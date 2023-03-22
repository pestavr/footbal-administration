@if ($kind==1)
	 <div class="form-group">
        <label for="onoma_web">Από</label>
        <input type="text" class="form-control form_datetime" id="dateFrom" name="dateFrom" >        
      </div>
      <div class="form-group">
        <label for="onoma_web">Μέχρι</label>
        <input type="text" class="form-control form_datetime" id="dateTo" name="dateTo" >        
      </div>
      <input type="hidden" class="form-control" name="kind" value="1">
@endif
@if ($kind==2)
	<?php $days= [1=>'Δευτέρα', 2=>'Τρίτη', 3=>'Tετάρτη', 4=>'Πέμπτη', 5=>'Παρασκευή', 6=>'Σάββατο', 7=>'Κυριακή'] ?>
	<div class="row">
		<div class="col-md-12">
			<p>Εδώ ορίζετε τις ημέρες που ο Διαιτητής <strong><u>ΔΕΝ</u></strong> μπορεί να συμμετάσχει σε κάποια αναμέτρηση</p>
		</div>
	</div>
	@foreach($days as $k=>$v)
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
		        <label for="onoma_web">{{$v}}</label>
		        <input type="checkbox" name="days[{{$k}}]" class="days" id="day-{{$k}}" rel="{{$k}}">
		    </div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
		         <?php $items= [0=>'Όλη Μέρα', 1=>'Πριν Από', 2=>'Μετά Από']; ?>
		         <label for="iso">Διάρκεια</label>
	            <CENTER>{!! Form::select('compare-'.$k,  $items, null, ['class'=>'form-control compare', 'id'=>'compare-'.$k, 'data-style'=>'btn-danger', 'rel'=>$k , 'disabled'=>'disabled']) !!}</CENTER>
	        </div>    
		</div>
		<div class="col-md-4">
			<div class="form-group">
	             <label for="iso">Ώρα</label>
	            <CENTER>{!! Form::text('time-'.$k,  null, ['class'=>'form-control time', 'id'=>'time-'.$k, 'data-style'=>'btn-danger', 'disabled'=>'disabled']) !!}</CENTER>
	        </div>    
		</div>
	 </div>
	 @endforeach
	 <input type="hidden" class="form-control" name="kind" value="2">
@endif
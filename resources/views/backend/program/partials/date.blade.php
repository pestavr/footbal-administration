<div class="input-append date form_datetime" data-date="{{$dataDate}}" data-link="data-input-{{$match}}">
	{{Form::text('datetime-'.$match, $date , ['class'=>'form-control', 'id'=>'data-input-'.$match, 'readonly'=> $readonly])}}
   
    <span class="add-on"><i class="icon-remove"></i></span>
    <span class="add-on"><i class="icon-calendar"></i></span>
</div>
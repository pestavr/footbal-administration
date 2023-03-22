 @foreach($matches as $match)
 <div>
 {{Form::open(['method' => 'post', 'route' => array('admin.program.program.linkUpdate',$match->id)])}}
  <div class="row">
  	<div class="col-md-12">
	  	<div class="form-group">
	        <label for="score_team_1">Εισαγωγή Υπερσύνδεσμου Αναμέτρησης</label>
	        {!! Form::text('link', $match->link, ['class'=>'form-control']) !!}
	     </div>
  	</div>
  </div>
  <div class="row">
	    <center><button type="submit" id="show" class="btn btn-primary" style="margin-top:10px;">Ενημέρωση</button></center>   
  </div>

 {{Form::close()}}
 </div>
 @endforeach
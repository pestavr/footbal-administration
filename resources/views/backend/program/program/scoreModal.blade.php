 @foreach($matches as $match)
 {{Form::open(['method' => 'post', 'route' => array('admin.program.program.scoreUpdate',$match->id)])}}
  <div class="row">
  	<div class="col-md-6">
	  	<div class="form-group">
	        <label for="score_team_1">{{$match->ghp}}</label>
	        <input type="text" class="form-control" id="score_team_1" name="score_team_1" value="{{ $match->score_team_1 }}">
	     </div>
  	</div>
  	<div class="col-md-6">
	  	<div class="form-group">
	        <label for="score_team_2">{{$match->fil}}</label>
	        <input type="text" class="form-control" id="score_team_2" name="score_team_2" value="{{ $match->score_team_2 }}">
	     </div>
  	</div>
  </div>
  <div class="row">
	    <center><button type="submit" id="show" class="btn btn-primary" style="margin-top:10px;">Ενημέρωση</button></center>   
  </div>

 {{Form::close()}}
 @endforeach

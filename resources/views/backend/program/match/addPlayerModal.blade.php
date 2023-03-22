


  <div class="row">
  	<div class="col-md-6">
  		 <div class="box box-success">
            <div class="box-header with-border">
                 <h3 class="box-title">Αναζήτηση Ποδοσφαιριστή</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
            	<div class="form-group">
            		{{ csrf_field() }}
		            <label for="onoma_web">Δελτίο</label>
		            {!! Form::text('player_id', $value = '', [
		                'placeholder'   => 'Πληκτρολογείστε τον αριθμό δελτίου',
		                'id'            => 'player_id',
		                'class'         => 'form-control',
		                ]) !!}
		          </div>
		          <div class="form-group">
		            <label for="player">Όνοματεπώνυμο</label>
		           <input type="text" class="form-control" id="player" name="player" readonly>
		            
		          </div>
		          <div class="form-group">
		            <label for="F_name">Όνομα Πατέρα</label>
		            <input type="text" class="form-control" id="F_name" name="F_name" readonly>
		            
		          </div>
		          <div class="form-group">
		            <label for="BirthYear">Έτος Γέννησης</label>
		            <input type="text" class="form-control" id="BirthYear" name="BirthYear" readonly>
		            
		          </div>

		          <div class="form-group">
		            <label for="team_from">Ομάδα Προέλευσης</label>
		            <?php $teams= App\Models\Backend\team::orderBy('onoma_web', 'asc')->pluck('onoma_web', 'team_id');  
		              $teams->prepend('Επιλέξτε Ομάδα', config('default.team'));
		            ?>
		            {!! Form::select('team_from', $teams, null, ['class'=>'form-control', 'id'=>'team_from']) !!}
		            
		          </div>
		          <input type="hidden" class="form-control" id="team_to" name="team_to" value="{{$team}}">

		          <div class="form-group">
		          	<center><button type="button" id="insert_player" team="-1" class="btn btn-primary" style="margin-top:10px;">Εισαγωγή</button></center>
		          </div>
            </div>
	  	 </div>
	  	
  	</div>
  	<div class="col-md-6">
	  	<div class="box box-danger">
            <div class="box-header with-border">
                 <h3 class="box-title">Εισαγωγή Νέου Ποδοσφαιριστή</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	<div class="form-group">
		            <label for="onoma_web">Δελτίο</label>
		            {!! Form::text('id', $value = '', [
		                'placeholder'   => 'Πληκτρολογείστε τον αριθμό δελτίου',
		                'id'            => 'np_player_id',
		                'class'         => 'form-control',
		                ]) !!}
		          </div>
		          <div class="form-group">
		            <label for="player">Όνομα</label>
		           <input type="text" class="form-control" id="np_playerName" name="np_playerName">
		            
		          </div><div class="form-group">
		            <label for="player">Επώνυμο</label>
		           <input type="text" class="form-control" id="np_playerSurname" name="np_playerSurname">
		            
		          </div>
		          <div class="form-group">
		            <label for="F_name">Όνομα Πατέρα</label>
		            <input type="text" class="form-control" id="np_F_name" name="np_F_name">
		            
		          </div>
		          <input type="hidden" class="form-control" id="np_team_to" name="np_team_to" value="{{$team}}">
		          <div class="form-group">
		          	<center><button type="button" id="insert_new_player" class="btn btn-primary" style="margin-top:10px;">Εισαγωγή</button></center>
		          </div>
            </div>
	  	 </div>
  	</div>
  </div>
 




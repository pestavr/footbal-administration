@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ποδοσφαιριστές</small>
    </h1>
@endsection

@section('after-styles')

    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Εισαγωγή Νέου Ποδοσφαιριστή</h3>

           <div class="box-tools pull-right">
                <?php $data=['team'=>$team]; ?>
                @include('backend.includes.partials.playersPerTeam-header-buttons', $data)
            
          </div><!-- /.box-header -->
        </div>
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.file.players.do_insert') }}">
                    {{ csrf_field() }}
                     <div class="form-group">
                        <label for="exampleInputEmail1">Δελτίο</label>
                        <input type="text" class="form-control" id="player_id" name="player_id"  >
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Επώνυμο</label>
                        <input type="text" class="form-control" id="Lastname" name="Lastname" >
                        
                      </div>
                      <div class="form-group">
                        <label for="Firstname">Όνομα</label>
                        <input type="text" class="form-control" id="Firstname" name="Firstname">
                        
                      </div>
                      <div class="form-group">
                        <label for="Fname">Όνομα Πατέρα</label>
                        <input type="text" class="form-control" id="Fname" name="Fname" >
                        
                      </div>
                      <div class="form-group">
                        <label for="Bdate">Ημερομηνία Γέννησης</label>
                        <input type="text" class="form-control" id="Bdate" name="Bdate" placeholder="ηη/μμ/ΕΕΕΕ" >
                        
                      </div>
                      <div class="form-group">
                        <label for="country">Χώρα</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Ελλάδα" >
                        
                      </div>
                      <div class="form-group">
                        <label for="position">Θέση</label>
                        {!! Form::select('position', ['0'=>'Επιλέξτε Θέση','1'=> 'Τερματοφύλακας','2'=> 'Αμυντικός','3'=> 'Μέσος','4'=> 'Επιθετικός'] , null, ['class'=>'form-control']) !!}
                       
                      </div>
                      <div class="form-group">
                        <label for="team">Ομάδα</label>
                        <?php $items= App\Models\Backend\team::orderBy('onoma_web')->pluck('onoma_web', 'team_id');  ?>
                        {!! Form::select('team', $items, $team, ['class'=>'form-control']) !!}
                        
                      </div>                     

                      
                      <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                    </form>
            </div>
    </div><!--box-->
    
</div>
        
@endsection

@section('after-scripts')
    
    {{ Html::script("//code.jquery.com/ui/1.11.2/jquery-ui.js") }}
    
    <script>

      jQuery(function() {
          jQuery( "#Bdate" ).datepicker({
            format: 'd/m/Y'
          });
      });

    </script>
@endsection
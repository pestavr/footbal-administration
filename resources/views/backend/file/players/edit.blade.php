@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ποδοσφαιριστές</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Επεξεργασία Ποδοσφαιριστή</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.players-header-buttons')
            </div>
        </div><!-- /.box-header -->
        @foreach ($players as $players)
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.file.players.update', $players->id) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Δελτίο</label>
                        <input type="text" class="form-control" id="player_id" name="player_id"  value="{{ $players->id }}" readonly>
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Επώνυμο</label>
                        <input type="text" class="form-control" id="Lastname" name="Lastname" value="{{ $players->Surname }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Firstname">Όνομα</label>
                        <input type="text" class="form-control" id="Firstname" name="Firstname" value="{{ $players->Name }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Fname">Όνομα Πατέρα</label>
                        <input type="text" class="form-control" id="Fname" name="Fname" value="{{ $players->F_name}}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Bdate">Ημερομηνία Γέννησης</label>
                        <input type="text" class="form-control" id="Bdate" name="Bdate" value="{{ \Carbon\Carbon::parse($players->Birthdate)->format('d/m/Y') }}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="country">Χώρα</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Ελλάδα" value="{{ $players->country }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="position">Θέση</label>
                        {!! Form::select('position', ['0'=>'Επιλέξτε Θέση','1'=> 'Τερματοφύλακας','2'=> 'Αμυντικός','3'=> 'Μέσος','4'=> 'Επιθετικός'] , $players->position , ['class'=>'form-control']) !!}
                       
                      </div>
                      <div class="form-group">
                        <label for="team">Ομάδα</label>
                        <?php $items= App\Models\Backend\team::orderBy('onoma_web')->pluck('onoma_web', 'team_id');  ?>
                        {!! Form::select('team', $items, $players->teams_team_id, ['class'=>'form-control']) !!}
                        
                      </div>                     
                      
                      

                      
                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    </form>
            </div>
    </div><!--box-->
  </div>
    @endforeach
    
        
@endsection

@section('after-scripts')
    
    {{ Html::script("//code.jquery.com/ui/1.11.2/jquery-ui.js") }}
    
    <script>

      $(function() {
          $( "#Bdate" ).datepicker({
            format: 'd/m/Y'
          });
      });

    </script>
@endsection
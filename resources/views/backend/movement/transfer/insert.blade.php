@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Μεταγραφές</small>
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
            <h3 class="box-title">Εισαγωγή Νέας Μεταγραφής</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.transfer-header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => 'admin.move.transfer.do_insert', 'files' => false])}}
                
                    {{ csrf_field() }}
                      <div class="form-group">
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
                        <?php $teams= App\Models\Backend\team::selectRaw('CONCAT(onoma_web, " - ", Age_Level_Title) as teamAge, team_id')->join('age_level','age_level.id','=', 'teams.age_level')->orderBy('onoma_web', 'asc')->pluck('teamAge', 'team_id');  
                          $teams->prepend('Επιλέξτε Ομάδα', config('default.team'));
                        ?>
                        {!! Form::select('team_from', $teams, null, ['class'=>'form-control', 'id'=>'team_from']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="team_to">Ομάδα Προορισμού</label>
                        {!! Form::select('team_to', $teams, null, ['class'=>'form-control', 'id'=>'team_to']) !!}
                        
                      </div>                
                      <div class="form-group">
                        <label for="Date">Ημερομηνία</label>
                        <input type="text" class="form-control" id="Date" name="Date" value="{{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d/m/Y') }}">
                        
                      </div>
                      
                      <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    
    
        
@endsection

@section('after-scripts')

    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    
    <script>

      $(function() {
          $( "#Bdate" ).datepicker({
            format: 'd/m/Y'
          });
          $("#player_id").autocomplete({
              source: function( request, response ) {
                                  $.ajax( {
                                    url: "{{ route('admin.file.players.getPlayer') }}",
                                    dataType: "json",
                                    data: {
                                      term: request.term
                                    },
                                    success: function( data ) {
                                      response( data );
                                    },
                                    error: function (xhr, err) {
                                        //if (err === 'parsererror')
                                            console.log(xhr.responseText);
                                            exit();
                                    }
                                  } );
                                },
              minLength: 2,
              select: function(event, ui) {
                //alert (ui);
                $('#player_id').val(ui.item.id);
                $('#player').val(ui.item.player);
                $('#F_name').val(ui.item.fname);
                $('#BirthYear').val(ui.item.BirthYear);  
                $('#team_from').val(ui.item.team);               
              }
          });
      });

    </script>
@endsection
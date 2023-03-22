@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ποινές</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style(asset('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css'))}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Εισαγωγή Ποινής Ποδοσφαιριστή</h3>

           <div class="box-tools pull-right">

                @include('backend.penalty.partials.player-header-buttons')
            </div>
        </div><!-- /.box-header -->
       
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.penalty.player.do_insert') }}">
                    {{ csrf_field() }}
                    <h5>Στοιχεία Ποδοσφαιριστή</h5>
                    <hr/>

                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="player_id">Δελτίο</label>
                            {!! Form::text('player_id', $value = '', [
                            'placeholder'   => 'Πληκτρολογείστε τον αριθμό δελτίου',
                            'id'            => 'player_id',
                            'class'         => 'form-control',
                            ]) !!}
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="pl_surname">Ονοματεπώνυμο</label>
                            <input type="text" class="form-control" id="pl_surname" name="pl_surname" readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="Fname">Όνομα Πατέρα</label>
                            <input type="text" class="form-control" id="Fname" name="Fname" readonly>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="BirthYear">Ημερομηνία Γέννησης</label>
                            <input type="text" class="form-control" id="BirthYear" name="BirthYear" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="team">Ομάδα</label>
                          <div class="input-group input-group-lg">
                            <span class="input-group-addon" id="sizing-addon1"><a href="{{route('admin.move.transfer.insert')}}" target="_blank"><i class="glyphicon glyphicon-refresh"></i></a></span>
                            <input type="text" name="team" id="team_name" class="form-control"  aria-describedby="sizing-addon1" readonly>
                          </div>
                          <input type="hidden" name="team_id" id="team" class="form-control" >
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12" id="history">

                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12" id="recentMatches">
                         
                          </div>
                        </div>
                      </div>
                      <h5>Αιτιολογία Ποινής</h5>
                    <hr/>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="infliction_date">Ημερομηνία Επιβολής</label>
                            <input type="text" class="form-control datepicker" id="infliction_date" name="infliction_date" >
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="decision_num">Αριθμός Απόφασης</label>
                            <input type="text" class="form-control" id="decision_num" name="decision_num">
                          </div>
                          </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="reason">Αιτιολογία</label>
                            <input type="text" class="form-control" id="reason" name="reason" >
                          </div>
                        </div>
                    </div>
                    <h5>Ποινή</h5>
                    <hr/>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="fine">Χρηματική Ποινή</label>
                            <input type="text" class="form-control" id="fine" name="fine">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="match_days">Αγωνιστικές</label>
                            <input type="text" class="form-control" id="match_days" name="match_days" >
                            {!! Form::select('kind_of_days', ['1'=> 'Αγωνιστικές','2'=> 'Ημερολογιακές Ημέρες','3'=> 'Μήνες'] , null , ['class'=>'form-control']) !!}
                          </div>
                          </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="reproof">Επίπληξη</label>
                            <input type="text" class="form-control" id="reproof" name="reproof">
                          </div>
                        </div>
                    </div> 
                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    </form>
            </div>
    </div><!--box-->
  </div>
  
    
        
@endsection

@section('after-scripts')
    
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.el.js")) }}
    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    
    <script>

      $(function() {

           $(document).on('focus','.datepicker', function(){
                           
                            $(this).datetimepicker({
                                        language:  'el',
                                        format: "dd/mm/yyyy",
                                        autoclose: true,
                                        todayBtn: true,
                                        minView: 2,
                                        pickerPosition: "bottom-left",
                                        initialDate: new Date()
                                    })
                                   
                            
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
                $('#pl_surname').val(ui.item.player);
                $('#Fname').val(ui.item.fname);
                $('#BirthYear').val(ui.item.BirthYear);  
                $('#team').val(ui.item.team);  
                $('#team_name').val(ui.item.team_name); 

                  $.ajax( {
                          url: "{{ route('admin.penalty.player.getHistory') }}",
                          data: {
                            id: ui.item.id
                          },
                          success: function( data ) {
                                   $('#history').html(data);
                          },
                          error: function (xhr, err) {
                              //if (err === 'parsererror')
                                  console.log(xhr.responseText);
                                  exit();
                          }
                        } );
                $.ajax( {
                      url: "{{ route('admin.penalty.player.recentMatches') }}",
                      data: {
                        id: ui.item.team
                      },
                      success: function( data ) {
                               $('#recentMatches').html(data);
                      },
                      error: function (xhr, err) {
                          //if (err === 'parsererror')
                              console.log(xhr.responseText);
                              exit();
                      }
                    });           
              }
          });
      });

    </script>
@endsection
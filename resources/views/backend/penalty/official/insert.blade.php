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
            <h3 class="box-title">Εισαγωγή Ποινής Αξιωματούχου</h3>

           <div class="box-tools pull-right">

                @include('backend.penalty.partials.official-header-buttons')
            </div>
        </div><!-- /.box-header -->
       
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.penalty.official.do_insert') }}">
                    {{ csrf_field() }}
                     <h5>Στοιχεία Αξιωματούχου</h5>
                    <hr/>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="name">Ονοματεπώνυμο</label>
                            <input type="text" class="form-control" id="name" name="name" >
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="title">Θέση στην Ομάδα</label>
                            <input type="text" class="form-control" id="title" name="title" >
                          </div>
                          </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="player_id">Ομάδα</label>
                            <?php $teams= App\Models\Backend\team::where('age_level','=', 1)->orderBy('onoma_web', 'asc')->pluck('onoma_web', 'team_id');   
                             $teams->prepend('Επιλέξτε Ομάδα στην οποία ανήκει', 0);
                            ?>
                              {!! Form::select('team', $teams, null, ['class'=>'form-control', 'id'=>'team']) !!}
                          </div>
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
                            <label for="description">Περιγραφή</label>
                            <input type="text" class="form-control" id="description" name="description" >
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Εισαγωγή</button>
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
            $(document).on('change','#team', function(){
              var team=$(this).val();
                  
                      $.ajax( {
                            url: "{{ route('admin.penalty.official.recentMatches') }}",
                            data: {
                              id: team
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
              });      
      });

    </script>
@endsection
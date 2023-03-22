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
        @foreach ($player as $pl)
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
                            <input type="text" class="form-control" id="player_id" name="player_id"  value="{{ $pl->player_id }}" readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="pl_surname">Επώνυμο</label>
                            <input type="text" class="form-control" id="pl_surname" name="pl_surname" value="{{ $pl->Surname }}" readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="pl_name">Όνομα</label>
                            <input type="text" class="form-control" id="pl_name" name="pl_name" value="{{ $pl->Name }}" readonly>
                          </div>
                          </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="Fname">Όνομα Πατέρα</label>
                            <input type="text" class="form-control" id="Fname" name="Fname" value="{{ $pl->F_name}}" readonly>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="Birthdate">Ημερομηνία Γέννησης</label>
                            <input type="text" class="form-control" id="Birthdate" name="Birthdate" value="{{ \Carbon\Carbon::parse($pl->Birthdate)->format('d/m/Y') }}" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="team">Ομάδα</label>
                            <input type="text" class="form-control" id="team" name="team" value="{{ $pl->team_name }}" readonly>
                            <input type="hidden" class="form-control" id="team_id" name="team_id" value="{{ $pl->team_id }}" readonly>
                          </div>
                        </div>
                    </div>
                    <h5>Αιτιολογία Ποινής</h5>
                    <hr/>
                    @endforeach 
                    @foreach ($match as $m)
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Αναμέτρηση</label>
                            <label for="team">Ομάδα</label>
                        <?php 
                          $text= \Carbon\Carbon::parse($m->date_time)->format('d/m/Y H:i').' '.$m->onoma_ghp.' - '.$m->onoma_fil;
                        ?>
                        <input type="text" class="form-control" id="match" name="match" value="{{ $text }}" readonly>
                       <input type="hidden" class="form-control" id="match_id" name="match_id" value="{{ $m->aa_game }}" readonly>
                      </div>  
                    </div>
                    @endforeach
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="infliction_date">Ημερομηνία Επιβολής</label>
                            <input type="text" class="form-control datepicker" id="infliction_date" name="infliction_date" value="">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="decision_num">Αριθμός Απόφασης</label>
                            <input type="text" class="form-control" id="decision_num" name="decision_num" value="">
                          </div>
                          </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="reason">Αιτιολογία</label>
                            <input type="text" class="form-control" id="reason" name="reason" value="">
                          </div>
                        </div>
                    </div>
                    <h5>Ποινή</h5>
                    <hr/>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="fine">Χρηματική Ποινή</label>
                            <input type="text" class="form-control" id="fine" name="fine" value="">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="match_days">Αγωνιστικές</label>
                            <input type="text" class="form-control" id="match_days" name="match_days" value="">
                            {!! Form::select('kind_of_days', ['1'=> 'Αγωνιστικές','2'=> 'Ημερολογιακές Ημέρες','3'=> 'Μήνες'] , '' , ['class'=>'form-control']) !!}
                          </div>
                          </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="reproof">Επίπληξη</label>
                            <input type="text" class="form-control" id="reproof" name="reproof" value="">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="remain">Υπόλοιπο</label>
                            <input type="text" class="form-control" id="remain" name="remain" value="">
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
      });

    </script>
@endsection
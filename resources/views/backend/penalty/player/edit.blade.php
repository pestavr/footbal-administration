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
            <h3 class="box-title">Επεξεργασία Ποινής Ποδοσφαιριστή</h3>

           <div class="box-tools pull-right">

                @include('backend.penalty.partials.player-header-buttons')
            </div>
        </div><!-- /.box-header -->
        @foreach ($players as $player)
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.penalty.player.update', $player->id) }}">
                    {{ csrf_field() }}
                    <h5>Στοιχεία Ποδοσφαιριστή</h5>
                    <hr/>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="player_id">Δελτίο</label>
                            <input type="text" class="form-control" id="player_id" name="player_id"  value="{{ $player->player_id }}" readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="pl_surname">Επώνυμο</label>
                            <input type="text" class="form-control" id="pl_surname" name="pl_surname" value="{{ $player->pl_surname }}" readonly>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="pl_name">Όνομα</label>
                            <input type="text" class="form-control" id="pl_name" name="pl_name" value="{{ $player->pl_name }}" readonly>
                          </div>
                          </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="Fname">Όνομα Πατέρα</label>
                            <input type="text" class="form-control" id="Fname" name="Fname" value="{{ $player->F_name}}" readonly>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="Birthdate">Ημερομηνία Γέννησης</label>
                            <input type="text" class="form-control" id="Birthdate" name="Birthdate" value="{{ \Carbon\Carbon::parse($player->Birthdate)->format('d/m/Y') }}" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="team">Ομάδα</label>
                            <input type="text" class="form-control" id="team" name="team" value="{{ $player->team_name }}" readonly>
                            <input type="hidden" class="form-control" id="team_id" name="team_id" value="{{ $player->team_id }}" readonly>
                          </div>
                        </div>
                    </div>
                    <h5>Αιτιολογία Ποινής</h5>
                    <hr/>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Αναμέτρηση</label>
                            <label for="team">Ομάδα</label>
                        <?php
                        $team=$player->team_id;
                        $items= App\Models\Backend\matches::join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                                                                  ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                                                                  ->whereRaw('date_time>="'.\Carbon\Carbon::parse($player->infliction_date)->subDays(20)->format('Y/m/d').'"')
                                                                  ->where(function($query) use ($team){
                                                                        $query->where('team1','=', $team)
                                                                              ->orWhere('team2','=', $team);
                                                                    })
                                                                  ->whereRaw('score_team_1 is not null')
                                                                  ->selectRaw('CONCAT(DAY(date_time),"/",MONTH(date_time),"/",YEAR(date_time)," | ",teams1.onoma_web," - ",teams2.onoma_web) as m, `matches`.`aa_game`')
                                                                  ->orderBy('date_time','desc')
                                                                  ->pluck('m', 'aa_game');  ?>
                        {!! Form::select('match_id', $items, $player->match_id, ['class'=>'form-control']) !!}
                        
                      </div>  
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="infliction_date">Ημερομηνία Επιβολής</label>
                            <input type="text" class="form-control datepicker" id="infliction_date" name="infliction_date" value="{{ \Carbon\Carbon::parse($player->infliction_date)->format('d/m/Y') }}">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="decision_num">Αριθμός Απόφασης</label>
                            <input type="text" class="form-control" id="decision_num" name="decision_num" value="{{ $player->decision_num}}">
                          </div>
                          </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="reason">Αιτιολογία</label>
                            <input type="text" class="form-control" id="reason" name="reason" value="{{ $player->reason}}">
                          </div>
                        </div>
                    </div>
                    <h5>Ποινή</h5>
                    <hr/>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="fine">Χρηματική Ποινή</label>
                            <input type="text" class="form-control" id="fine" name="fine" value="{{ $player->fine }}">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="match_days">Αγωνιστικές</label>
                            <input type="text" class="form-control" id="match_days" name="match_days" value="{{ $player->match_days }}">
                            {!! Form::select('kind_of_days', ['1'=> 'Αγωνιστικές','2'=> 'Ημερολογιακές Ημέρες','3'=> 'Μήνες'] , $player->kind_of_days , ['class'=>'form-control']) !!}
                          </div>
                          </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="reproof">Επίπληξη</label>
                            <input type="text" class="form-control" id="reproof" name="reproof" value="{{ $player->reproof}}">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="remain">Υπόλοιπο</label>
                            <input type="text" class="form-control" id="remain" name="remain" value="{{ $player->remain}}">
                          </div>
                        </div>
                    </div> 
                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    </form>
            </div>
    </div><!--box-->
  </div>
    @endforeach
    
        
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
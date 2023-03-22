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
            <h3 class="box-title">Επεξεργασία Ποινής Ομάδας</h3>

           <div class="box-tools pull-right">

                @include('backend.penalty.partials.team-header-buttons')
            </div>
        </div><!-- /.box-header -->
        @foreach ($teams as $team)
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.penalty.team.update', $team->id) }}">
                    {{ csrf_field() }}
                    <h5>Στοιχεία Ομάδας</h5>
                    <hr/>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="team">Ομάδα</label>
                           <?php $teams= App\Models\Backend\team::where('age_level','=', 1)->orderBy('onoma_web', 'asc')->pluck('onoma_web', 'team_id');   
                             $teams->prepend('Επιλέξτε Ομάδα στην οποία ανήκει', 0);
                            ?>
                              {!! Form::select('team', $teams, $team->team_id, ['class'=>'form-control']) !!}
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="pl_surname">Αναμέτρηση</label>
                             <?php
                        $team_p=$team->team_id;
                        $items= App\Models\Backend\matches::join('teams as teams1' , 'matches.team1','=','teams1.team_id')
                                                                  ->join('teams as teams2' , 'matches.team2','=','teams2.team_id')
                                                                  ->whereRaw('date_time>="'.\Carbon\Carbon::parse($team->infliction_date)->subDays(20)->format('Y/m/d').'"')
                                                                  ->where(function($query) use ($team_p){
                                                                        $query->where('team1','=', $team_p)
                                                                              ->orWhere('team2','=', $team_p);
                                                                    })
                                                                  ->whereRaw('score_team_1 is not null')
                                                                  ->selectRaw('CONCAT(DAY(date_time),"/",MONTH(date_time),"/",YEAR(date_time)," | ",teams1.onoma_web," - ",teams2.onoma_web) as m, `matches`.`aa_game`')
                                                                  ->orderBy('date_time','desc')
                                                                  ->pluck('m', 'aa_game');  ?>
                        {!! Form::select('match_id', $items, $team->match_id, ['class'=>'form-control']) !!}
                          </div>
                        </div>
                        
                    </div>
                   
                    <h5>Αιτιολογία Ποινής</h5>
                    <hr/>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="infliction_date">Ημερομηνία Επιβολής</label>
                            <input type="text" class="form-control datepicker" id="infliction_date" name="infliction_date" value="{{ \Carbon\Carbon::parse($team->infliction_date)->format('d/m/Y') }}">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="decision_num">Αριθμός Απόφασης</label>
                            <input type="text" class="form-control" id="decision_num" name="decision_num" value="{{ $team->decision_num}}">
                          </div>
                          </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="reason">Αιτιολογία</label>
                            <input type="text" class="form-control" id="reason" name="reason" value="{{ $team->reason}}">
                          </div>
                        </div>
                    </div>
                    <h5>Ποινή</h5>
                    <hr/>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="fine">Χρηματική Ποινή</label>
                            <input type="text" class="form-control" id="fine" name="fine" value="{{ $team->fine }}">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="match_days">Αγωνιστικές</label>
                            <input type="text" class="form-control" id="match_days" name="match_days" value="{{ $team->match_days }}"> 
                          </div>
                          </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="description">Περιγραφή</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ $team->description}}">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="pointsoff">Αφαίρεση Βαθμών</label>
                            <input type="text" class="form-control" id="pointsoff" name="pointsoff" value="{{ $team->pointsoff}}">
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-group">
                            <label for="remain">Υπόλοιπο</label>
                            <input type="text" class="form-control" id="remain" name="remain" value="{{ $team->remain}}">
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
@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Πρωταθλήματα</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Επεξεργασία Ομίλου</h3>

           <div class="box-tools pull-right">

                @include('backend.competition.partials.championship-header-buttons')
            
        </div><!-- /.box-header -->
        @foreach ($groups as $group)
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => array('admin.competition.championship.saveTeams',$group->id), 'files' => true])}}
                    {{ csrf_field() }}
                      

                    <div class="row">
                      <h5><strong>Ομάδες Ομίλου</strong></h5>  
                      <?php 
                      $all_teams=\App\Models\Backend\team::where('teams.age_level', '=', $group->age_level)
                                                            ->orderBy('onoma_web')
                                                            ->distinct()
                                                            ->pluck('onoma_web','team_id');
                      $teams_selected=\App\Models\Backend\team::select('onoma_web','team_id')->join('teamspergroup', 'teamspergroup.team', '=', 'teams.team_id')->where('group','=',$group->id)->orderBy('onoma_web')->get(); 
                        ?>
                      @foreach($teams_selected as $team)
                      <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::select('teams['.$team->team_id.']',  $all_teams, $team->team_id, ['class'=>'form-control',  'data-style'=>'btn-danger']) !!}
                        </div>
                      </div> 
                      @endforeach
                      
                        
                    </div>
            </div>  
                      <center><button type="submit" class="btn btn-primary">Ενημέρωση</button></center>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    @endforeach
    
        
@endsection

@section('after-scripts')
   
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js") }}
    
    <script>
$(document).ready(function () {
  
});
    </script>
@endsection
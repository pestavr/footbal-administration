@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Εισαγωγή Στοιχείων Αναμετρήσεων</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
    {{ Html::style(asset('assets/SmartWizard/dist/css/smart_wizard.css'))}}
    {{ Html::style(asset('assets/SmartWizard/dist/css/smart_wizard_theme_arrows.css'))}}
    {{ Html::style(asset('assets/noty/lib/noty.css'))}}
    {{ Html::style(asset('assets/noty/lib/themes/mint.css'))}}
   
@endsection

@section('content')

<div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Εισαγωγή Στοιχείων Αναμέτρησης</h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->
@foreach($match as $m)
        <input type="hidden" id="match_id" value="{{$m->aa_game}}"/>
        <input type="hidden" id="team1_id" value="{{$m->team1_id}}"/>
        <input type="hidden" id="team2_id" value="{{$m->team2_id}}"/>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <p><center><h3>{{$m->category}}- {{$m->match_day}}η Αγωνιστική</h3></center></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 text-right">
                    <p><h4><strong>{{$m->team1_name}}</strong></h4></p>
                </div>
                <div class="col-md-1">
                    <p><center><h1>{{$m->score_1}}</h1></center></p>
                </div>
                <div class="col-md-1">
                    <p><center><h1>{{$m->score_2}}</h1></center></p>
                </div>
                <div class="col-md-5">
                    <p><h4><strong>{{$m->team2_name}}</strong></h4></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-right">
                    <p><h5><strong>Ημερομηνία και Ώρα: </strong>{{ \Carbon\Carbon::parse($m->date_time)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($m->date_time)->format('H:i') }}</h5></p>
                </div>
                <div class="col-md-6">
                    <p><h5><strong>Γήπεδο:</strong> {{$m->gipedo}}</h5></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-right">
                    <p><h5><strong>Διαιτητής:</strong> {{ $m->ref_last }} {{$m->ref_first }}</h5></p>
                </div>
                <div class="col-md-6">
                    <p><h5><strong>Βοηθοί:</strong> {{ $m->help1_last }} {{$m->help1_first }}- {{ $m->help2_last }} {{$m->help2_first }}</h5></p>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-12 text-center">
                    <p><h5><strong>Διάρκεια:</strong> 
                            <select id="duration">
                                <option value="60">60'</option>
                                <option value="75">75'</option>
                                <option value="90" selected="selected">90'</option>
                                <option value="120">120'</option>
                            </select></h5></p>
                </div>
            </div> 
        </div><!-- /.box-body -->
    @endforeach
    </div><!--box-->

<div class="box box-danger">
        <div class="box-header with-border">
             <h3 class="box-title">Επεξεργασία Στοιχείων</h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->
<?php 
$team1_list= Array();
$team2_list= Array();
$select1=Array();
$select2=Array();
foreach($players as $player){
     if ($player->team_id==$m->team1_id){
          $team1_list[$player->pos]['mp_id']=$player->mp_id;
          $team1_list[$player->pos]['player_id']=$player->player_id;
          $select1[$player->player_id]=$player->player_id.'-'.$player->surname.' '.$player->name;
          $team1_list[$player->pos]['surname']=$player->surname;
          $team1_list[$player->pos]['name']=$player->name;
          }else{
          $team2_list[$player->pos]['mp_id']=$player->mp_id;
          $team2_list[$player->pos]['player_id']=$player->player_id;
          $select2[$player->player_id]=$player->player_id.'-'.$player->surname.' '.$player->name;
          $team2_list[$player->pos]['surname']=$player->surname;
          $team2_list[$player->pos]['name']=$player->name;
        }
}
$goal1_list=Array();
$goal2_list=Array();
$i=0;
$j=0;
foreach($goals as $goal){
    if ($goal->owngoal==0){
        if ($goal->team==$m->team1_id){
                  $goal1_list[$i]['id']=$goal->goal_id;
                  $goal1_list[$i]['pos']=$goal->player_id;
                  $goal1_list[$i]['goal']=$goal->goal;
                  $goal1_list[$i]['owngoal']=$goal->owngoal==1?true:false;
                  $goal1_list[$i]['penalty']=$goal->penalty==1?true:false;
                  $i++;
        }else{
                  $goal2_list[$j]['id']=$goal->goal_id;
                  $goal2_list[$j]['pos']=$goal->player_id;
                  $goal2_list[$j]['goal']=$goal->goal;
                  $goal2_list[$j]['owngoal']=$goal->owngoal==1?true:false;
                  $goal2_list[$j]['penalty']=$goal->owngoal==1?true:false;
                  $j++;
        }
    }else{
        if ($goal->team==$m->team1_id){
                  $goal2_list[$j]['id']=$goal->goal_id;
                  $goal2_list[$j]['pos']=$goal->player_id;
                  $goal2_list[$j]['goal']=$goal->goal;
                  $goal2_list[$j]['owngoal']=$goal->owngoal==1?true:false;
                  $goal2_list[$j]['penalty']=$goal->penalty==1?true:false;
                  $j++;
        }else{
                  $goal1_list[$i]['id']=$goal->goal_id;
                  $goal1_list[$i]['pos']=$goal->player_id;
                  $goal1_list[$i]['goal']=$goal->goal;
                  $goal1_list[$i]['owngoal']=$goal->owngoal==1?true:false;
                  $goal1_list[$i]['penalty']=$goal->owngoal==1?true:false;
                  $j++;
        }
    }
}
$red1_list=Array();
$red2_list=Array();
$yellow1_list=Array();
$yellow2_list=Array();
$i=0;
$j=0;
$iy=0;
$jy=0;
foreach($cards as $penalty){
    if ($penalty->team==$m->team1_id){
        if ($penalty->red>0){
            $red1_list[$i]['id']=$penalty->pen_id;
            $red1_list[$i]['pos']=$penalty->player_id;
            $red1_list[$i]['red']=$penalty->red;
            $i++;
        }else{
            if(config('settings.yellow')){
                $yellow1_list[$iy]['id']=$penalty->pen_id;
                $yellow1_list[$iy]['pos']=$penalty->player_id;
                $yellow1_list[$iy]['yellow']=$penalty->yellow;
                $iy++;
            }
        }
        
    }else{
        if ($penalty->red>0){
            $red2_list[$j]['id']=$penalty->pen_id;
            $red2_list[$j]['pos']=$penalty->player_id;
            $red2_list[$j]['red']=$penalty->red;
            $j++;
        }else{
            if(config('settings.yellow')){
                $yellow2_list[$jy]['id']=$penalty->pen_id;
                $yellow2_list[$jy]['pos']=$penalty->player_id;
                $yellow2_list[$jy]['yellow']=$penalty->yellow;
                $jy++;
            }
        }
              
        }
}
$sub1_list=Array();
$sub2_list=Array();
$i=0;
$j=0;
foreach($subs as $sub){
    if ($sub->team==$m->team1_id){
            $sub1_list[$i]['id']=$sub->sub_id;
            $sub1_list[$i]['out']=$sub->sub_out;
            $sub1_list[$i]['in']=$sub->sub_in;
            $sub1_list[$i]['min']=$sub->min;
            $i++;        
    }else{
            $sub2_list[$j]['id']=$sub->sub_id;
            $sub2_list[$j]['out']=$sub->sub_out;
            $sub2_list[$j]['in']=$sub->sub_in;
            $sub2_list[$j]['min']=$sub->min;
            $j++;
        }
}

?>
        <div class="box-body">
                         {{Form::open(['method' => 'post', 'route' => array('admin.program.match.saveEdit',$m->aa_game)])}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Συνθέσεις</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="syntheseis">
                                                <tr><th colspan="2">{{$m->team1_name}}</th><th></th><th colspan="2">{{$m->team2_name}}</th></tr>
                                                <tr><th>Δελτίο</th><th>Ονοματεπώνυμο</th><th></th><th>Ονοματεπώνυμο</th><th>Δελτίο</th></tr>
                                                @for ($i=1;$i<=18;$i++)
                                                <tr>
                                                    <td>
                                                        {{$team1_list[$i]['player_id'] or 'χωρις συμμετοχή'}}
                                                    </td>
                                                    <td id="playerTeam1">
                                                        {{$team1_list[$i]['surname'] or 'χωρις συμμετοχή'}} {{$team1_list[$i]['name'] or ''}}
                                                    </td>
                                                    <td>{{$i}}</td>
                                                    <td id="playerTeam2">
                                                        {{$team2_list[$i]['surname'] or 'χωρις συμμετοχή'}} {{$team2_list[$i]['name'] or ''}}
                                                    </td>
                                                    <td>
                                                        {{$team2_list[$i]['player_id'] or 'χωρις συμμετοχή'}}
                                                    </td>
                                                </tr>
                                               @endfor
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Αλλαγές για {{$m->team1_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="subs1">
                                                <thead>
                                                <tr><th>Μπήκε</th><th>Βγήκε</th><th>Λεπτό</th></tr>
                                                </thead>
                                                <tbody>
                                                     @for ($i=0;$i<sizeOf($sub1_list);$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('subOut1['.$i.']',  $select1, $sub1_list[$i]['out'],  ['class'=>'form-control', 'id'=>'sub_out1'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::select('subIn1'.$i,  $select1, $sub1_list[$i]['in'],  ['class'=>'form-control', 'id'=>'sub_in1'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','subMin1'.$i, $sub1_list[$i]['min'], array('class'=>'form-control datepicker', 'id'=>'subMin1'.$i)) !!}
                                                            {!! Form::input('hidden','subId1'.$i, $sub1_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'subMin1'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Αλλαγές για {{$m->team2_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="subs2">
                                                <thead>
                                                <tr><th>Μπήκε</th><th>Βγήκε</th><th>Λεπτό</th></tr>
                                                </thead>
                                                <tbody>
                                                     @for ($i=0;$i<sizeOf($sub2_list);$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('subOut2['.$i.']', $select2, $sub2_list[$i]['out'],  ['class'=>'form-control', 'id'=>'sub_out2'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::select('subIn2'.$i,  $select2, $sub2_list[$i]['in'],  ['class'=>'form-control', 'id'=>'sub_in2'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','subMin2'.$i, $sub2_list[$i]['min'], array('class'=>'form-control datepicker', 'id'=>'subMin2'.$i)) !!}
                                                            {!! Form::input('hidden','subId2'.$i, $sub2_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'subMin1'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Τέρματα για {{$m->team1_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="goal1">
                                                <thead>
                                                <tr><th>Ονοματεπώνυμο</th><th>Λεπτό</th><th>Αυτ</th><th>Πεν</th></tr>
                                                </thead>
                                                <tbody>
                                                     @for ($i=0;$i<$m->score_1;$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('scorer1['.$i.']',  ($goal1_list[$i]['owngoal'])?$select2:$select1, $goal1_list[$i]['pos'],  ['class'=>'form-control', 'id'=>'goal1'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','goalMin1'.$i, $goal1_list[$i]['goal'], array('class'=>'form-control datepicker', 'id'=>'goalMin1'.$i)) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::checkbox('goalOwn1'.$i, 'Αυτογκόλ', $goal1_list[$i]['owngoal'])!!}
                                                        </td>
                                                        <td>
                                                            {!! Form::checkbox('penalty1'.$i, 'Αυτογκόλ', $goal1_list[$i]['penalty']) !!}
                                                            {!! Form::input('hidden','goalId1'.$i, $goal1_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'goalId1'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Τέρματα για {{$m->team2_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="goal2">
                                                <thead>
                                                <tr><th>Ονοματεπώνυμο</th><th>Λεπτό</th><th>Αυτ</th><th>Πεν</th></tr>
                                            </thead>
                                            <tbody>
                                                    @for ($i=0;$i<$m->score_2;$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('scorer2['.$i.']',  ($goal2_list[$i]['owngoal'])?$select1:$select2, $goal2_list[$i]['pos'],  ['class'=>'form-control', 'id'=>'team', 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','goalMin2'.$i, $goal2_list[$i]['goal'], array('class'=>'form-control datepicker', 'id'=>'goalMin2'.$i)) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::checkbox('goalOwn2'.$i, 'Αυτογκόλ', $goal2_list[$i]['owngoal']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::checkbox('penalty2'.$i, 'Αυτογκόλ', $goal2_list[$i]['penalty']) !!}
                                                            {!! Form::input('hidden','goalId2'.$i, $goal2_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'goalId2'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                            </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Κόκκινες για {{$m->team1_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="red1">
                                                <thead>
                                                    <tr><th>Ονοματεπώνυμο</th><th>Λεπτό</th></tr>
                                                </thead>
                                                <tbody>
                                                     @for ($i=0;$i<sizeOf($red1_list);$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('red1['.$i.']',  $select1, $red1_list[$i]['pos'],  ['class'=>'form-control', 'id'=>'red1'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','redMin1'.$i, $red1_list[$i]['red'], array('class'=>'form-control datepicker', 'id'=>'redMin1'.$i)) !!}
                                                            {!! Form::input('hidden','redId1'.$i, $red1_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'redId1'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Κόκκινες για {{$m->team2_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="red2">
                                                <thead>
                                                    <tr><th>Ονοματεπώνυμο</th><th>Λεπτό</th></tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i=0;$i<sizeOf($red2_list);$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('red2['.$i.']',  $select2, $red2_list[$i]['pos'],  ['class'=>'form-control', 'id'=>'red2'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','redMin2'.$i, $red2_list[$i]['red'], array('class'=>'form-control datepicker', 'id'=>'redMin2'.$i)) !!}
                                                            {!! Form::input('hidden','redId2'.$i, $red2_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'redId2'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        @if(config('settings.yellow'))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Κίτρινες για {{$m->team1_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="yellow1">
                                                <thead>
                                                    <tr><th>Ονοματεπώνυμο</th><th>Λεπτό</th></tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i=0;$i<sizeOf($yellow1_list);$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('yellow1['.$i.']',  $select1, $yellow1_list[$i]['pos'],  ['class'=>'form-control', 'id'=>'yellow1'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','yellowMin1'.$i, $yellow1_list[$i]['yellow'], array('class'=>'form-control datepicker', 'id'=>'yellowMin1'.$i)) !!}
                                                            {!! Form::input('hidden','yellowId1'.$i, $yellow1_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'yellowId1'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                                 <h3 class="box-title">Κίτρινες για {{$m->team2_name}}</h3>
                                                 
                                    </div>
                                    <div class="box-body">
                                            <table class="table table-striped" id="yellow2">
                                                <thead>
                                                <tr><th>Ονοματεπώνυμο</th><th>Λεπτό</th></tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i=0;$i<sizeOf($yellow2_list);$i++)
                                                     <tr>
                                                        <td>
                                                            {!! Form::select('yellow2['.$i.']',  $select2, $yellow2_list[$i]['pos'],  ['class'=>'form-control', 'id'=>'yellow2'.$i, 'data-style'=>'btn-danger']) !!}
                                                        </td>
                                                        <td>
                                                            {!! Form::input('text','yellowMin2'.$i, $yellow2_list[$i]['yellow'], array('class'=>'form-control datepicker', 'id'=>'yellowMin2'.$i)) !!}
                                                            {!! Form::input('hidden','yellowId2'.$i, $yellow2_list[$i]['id'], array('class'=>'form-control datepicker', 'id'=>'yellowId2'.$i)) !!}
                                                        </td>
                                                     </tr>
                                                     @endfor
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        @endif   
                        <center><button type="submit" class="btn btn-primary" id="saveButton">Αποθήκευση</button></center>
                    {{Form::close()}}               
                    
        </div><!-- /.box-body -->
</div><!--box-->


<div id="match-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="termsLabel" class="modal-title">Εισαγωγή νέου ποδοσφαιριστή</h3>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->      
@endsection

@section('after-scripts')

    {{ Html::script(asset("assets/SmartWizard/dist/js/jquery.smartWizard.min.js")) }}}
    {{ Html::script(asset("assets/jquery-ui-1.12.1.custom/jquery-ui.min.js")) }}
    {{ Html::script(asset("assets/noty/lib/noty.js")) }}


    <script>
        $(document).ready(function () {
     $('#smartwizard').smartWizard();      
   //LIST CHANGE///
              var box1=0;
              var box2=0;
              var box3=0;
              var box4=0;
              var count1= new Array();
              var count2=new Array();
              var duration= $('#duration').val();
              for (i=0; i<18;i++){
                            count1[i]=i;
                            count2[i]=i;
              }
              var players1= new Array();
              var players2= new Array();
              var data1=new Array();
              ind1=0;
              $(document).on('click',".move", function(){
                            var cur=$(this);
                            var t= cur.text();
                            var pcs= t.split('-');
                            if (count1[0]!= undefined) {
                                          
                                          cur.html((parseInt(count1[0])+1)+'. '+t);
                                          if (count1[0]<11) {
                                                 players1.push({'num':parseInt(count1[0])+1, 'player':t, 'in':0, 'out':parseInt(duration)});
                                                 cur.appendTo('#box1');  
                                                 cur.removeClass('move');
                                                 cur.addClass('move_back');
                                                 cur.attr("list",'box1');
                                                 box1++;
                                                 //(box1>3)?$('#box1').height("+=30"):'';        
                                          }else{
                                                players1.push({'num':parseInt(count1[0])+1, 'player':t, 'in':0, 'out':0});
                                                $(this).appendTo('#box2');
                                                cur.removeClass('move');
                                                cur.addClass('move_back');
                                                cur.attr("list",'box2');
                                                box2++;
                                               //(box2>3)?$('#box2').height("+=30"):'';        
                                          }
                                          count1.shift();
                                          $('#next_player1').html(parseInt(count1[0]+1));
                                          
                            }
                                   
                             
                            });
              $(document).on('click',".move_back", function(){
                            var cur=$(this);
                            var t= cur.text();
                            var rem= t.split('.');
                            var pcs= rem[1].split('-');
                            cur.prependTo('#allItems');
                            cur.removeClass('move_back');
                            cur.addClass('move');
                            cur.html(rem[1]);
                            count1.push(parseInt(rem[0])-1);
                            count1.sort(function(a,b){return a - b}); 
                            $('#next_player1').html(parseInt(count1[0]+1));
                            players1=players1.filter(function(e){ return e.num != parseInt(rem[0]); });
                                                           
                                   if (cur.attr('list')=='box2') {
                                          //(box2>3)?$('#box2').height("-=30"):'';
                                          box2--;
                                          
                                   }else{
                                          //(box1>3)?$('#box1').height("-=30"):'';
                                          box1--;
                                   }
                                   
                                   cur.removeAttr('list');
                                   
                                   
                             
                            });
               $(document).on('click',".move1", function(){
                            var cur=$(this);
                            var t= cur.text();
                            var pcs= t.split('-');
                            if (count2[0]!= undefined) {
                                          
                                          cur.html((parseInt(count2[0])+1)+'. '+t);
                                          if (count2[0]<11) {
                                            players2.push({'num':parseInt(count2[0])+1, 'player':t, 'in':0, 'out':parseInt(duration)});
                                                 cur.appendTo('#box3');  
                                                 cur.removeClass('move1');
                                                 cur.addClass('move_back1');
                                                 cur.attr("list",'box3');
                                                 box3++;
                                                 //(box3>3)?$('#box3').height("+=30"):'';        
                                          }else{
                                                players2.push({'num':parseInt(count2[0])+1, 'player':t, 'in':0, 'out':0});
                                                $(this).appendTo('#box4');
                                                cur.removeClass('move1');
                                                cur.addClass('move_back1');
                                                cur.attr("list",'box4');
                                                box4++;
                                                //(box4>3)?$('#box4').height("+=30"):'';        
                                          }
                                          count2.shift();
                                          $('#next_player2').html(parseInt(count2[0]+1));
                                          
                            }
                             
                            });
              $(document).on('click',".move_back1", function(){
                            var cur=$(this);
                            var t= cur.text();
                            var rem= t.split('.');
                            var pcs= rem[1].split('-');
                            cur.prependTo('#allItems1');
                            cur.removeClass('move_back1');
                            cur.addClass('move1');
                            cur.html(rem[1]);
                            count2.push(parseInt(rem[0])-1);
                            count2.sort(function(a,b){return a - b}); 
                            $('#next_player2').html(parseInt(count2[0]+1));
                            players2=players2.filter(function(e){ return e.num != parseInt(rem[0]); });
                            
                                   
                                   if (cur.attr('list')=='box4') {
                                          //(box4>3)?$('#box4').height("-=30"):'';
                                          box4--;
                                          
                                   }else{
                                          //(box3>3)?$('#box3').height("-=30"):'';
                                          box3--;
                                   }
                                   
                                   cur.removeAttr('list');
                                   
                                   
                             
                            });
              $(document).on('focus','#player_id', function(){
                    $(this).autocomplete({
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

              $(document).on('blur',".player_team1", function(){
                            var cur=$(this);
                            show_in= cur.attr('show_in');
                            var team=cur.attr('team');

                            if ((parseInt(cur.val())<19 && parseInt(cur.val())>0 && parseInt(cur.val())<= players1.length) || (!$.trim(cur.val()).length && cur.attr('kind')!='goal')) {
                                            if (cur.attr('kind')=='sub'  )  {
                                                        var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                        $('#'+show_in).html(result[0].player);

                                                        $('.subOut'+team).not($(this)).each(function(index,element){
                                                                if (cur.val()==$(this).val()){
                                                                   new Noty({
                                                                                type:'alert',
                                                                                theme:'mint',
                                                                                text: 'Ο ποδοσφαιριστής έχει ξαναβγεί από τον αγωνιστικό χώρο. Δεν μπορεί να βγει δύο φορές',
                                                                                timeout: 2000
                                                                            }).show();
                                                                    $(this).focus();
                                                                    return false;
                                                                }
                                                        });
                                                }
                                                if ( cur.attr('kind')=='sub_in' )  {
                                                    
                                                        var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                        $('#'+show_in).html(result[0].player);

                                                        $('.subIn'+team).not($(this)).each(function(index,element){
                                                            
                                                                if (cur.val()==$(this).val()){
                                                                     new Noty({
                                                                                type:'alert',
                                                                                theme:'mint',
                                                                                text: 'Ο ποδοσφαιριστής έχει ξαναμπεί στον αγωνιστικό χώρο. Δεν μπορεί να μπει δύο φορές',
                                                                                timeout: 2000
                                                                            }).show();
                                                                    $(this).focus();
                                                                    return false;
                                                                }
                                                        });
                                                }
                                                if (cur.attr('kind')=='red') {
                                                        var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                        $('#'+show_in).html(result[0].player);
                                                        $('.red'+team).not($(this)).each(function(index,element){
                                                            
                                                                if (cur.val()==$(this).val()){
                                                                     new Noty({
                                                                                type:'alert',
                                                                                theme:'mint',
                                                                                text: 'Ο ποδοσφαιριστής έχει πάρει κόκκινη κάρτα. Δεν μπορεί να πάρει δύο φορές',
                                                                                timeout: 2000
                                                                            }).show();
                                                                    $(this).focus();
                                                                    return false;
                                                                }
                                                        });
                                                }
                                                if (cur.attr('kind')=='yellow') {
                                                        var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                        $('#'+show_in).html(result[0].player);
                                                        
                                                }
                                                if (cur.attr('kind')=='goal') {
                                                              goal=cur.attr('goal');
                                                              
                                                              if ($('#own_goal_team1'+goal).is(":checked")) {
                                                                      var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                                      $('#'+show_in).html(result[0].player);
                                                              }else{
                                                                      var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                                      $('#'+show_in).html(result[0].player);
                                                              }
                                                }            
                                          }else{
                                            new Noty({
                                                    type:'alert',
                                                    theme:'mint',
                                                    text: 'Δεν συμπληρώσατε σωστά τον αριθμό  της φανέλας',
                                                    timeout: 2000
                                                }).show();
                                            $(this).focus();
                                            return false;
                                                  
                                            }
                            
                             
                             
                            });

               $(document).on('blur',".player_team2", function(){
                            var cur=$(this);
                            show_in= cur.attr('show_in');
                            var team=cur.attr('team');
                            if ((parseInt(cur.val())<19 && parseInt(cur.val())>0 && parseInt(cur.val())<= players2.length) || (!$.trim(cur.val()).length && cur.attr('kind')!='goal')) {
                                            if (cur.attr('kind')=='sub' )  {
                                                                      var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                                      $('#'+show_in).html(result[0].player);  
                                                             $('.subOut'+team).not($(this)).each(function(index,element){
                                                                if (cur.val()==$(this).val()){
                                                                   new Noty({
                                                                                type:'alert',
                                                                                theme:'mint',
                                                                                text: 'Ο ποδοσφαιριστής έχει ξαναβγεί από τον αγωνιστικό χώρο. Δεν μπορεί να βγει δύο φορές',
                                                                                timeout: 2000
                                                                            }).show();
                                                                    $(this).focus();
                                                                    return false;
                                                                }
                                                        });     
                                                }
                                                 if ( cur.attr('kind')=='sub_in' )  {
                                                        
                                                        var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                        $('#'+show_in).html(result[0].player);

                                                        $('.subIn'+team).not($(this)).each(function(index,element){
                                                            
                                                                if (cur.val()==$(this).val()){
                                                                     new Noty({
                                                                                type:'alert',
                                                                                theme:'mint',
                                                                                text: 'Ο ποδοσφαιριστής έχει ξαναμπεί στον αγωνιστικό χώρο. Δεν μπορεί να μπει δύο φορές',
                                                                                timeout: 2000
                                                                            }).show();
                                                                    $(this).focus();
                                                                    return false;
                                                                }
                                                        });
                                                }
                                                if (cur.attr('kind')=='red') {
                                                                      var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                                      $('#'+show_in).html(result[0].player); 
                                                            $('.red'+team).not($(this)).each(function(index,element){
                                                                if (cur.val()==$(this).val()){
                                                                     new Noty({
                                                                                type:'alert',
                                                                                theme:'mint',
                                                                                text: 'Ο ποδοσφαιριστής έχει πάρει κόκκινη κάρτα. Δεν μπορεί να πάρει δύο φορές',
                                                                                timeout: 2000
                                                                            }).show();
                                                                    $(this).focus();
                                                                    return false;
                                                                }
                                                        });    
                                                }
                                                 if (cur.attr('kind')=='yellow') {
                                                        var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                        $('#'+show_in).html(result[0].player);
                                                        
                                                }
                                                if (cur.attr('kind')=='goal') {
                                                              goal=cur.attr('goal');
                                                              
                                                              if ($('#own_goal_team2'+goal).is(":checked")) {
                                                                           var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                                           $('#'+show_in).html(result[0].player);
                                                              }else{
                                                                            var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                                            $('#'+show_in).html(result[0].player);
                                                              }
                                                }            
                                          }else{
                                            new Noty({
                                                    type:'alert',
                                                    theme:'mint',
                                                    text: 'Δεν συμπληρώσατε σωστά τον αριθμό  της φανέλας',
                                                    timeout: 2000
                                                }).show();
                                            $(this).focus();
                                            return false;
                                                  
                                            }
                            
                            
                             
                             
                            });
                $(document).on('blur',".Min", function(){
                        var min=$(this).val();
                        var kind=$(this).attr('kind');
                        var team=$(this).attr('team');
                        var k=$(this).attr('k');
                        if (min>parseInt(duration)+10 || min<0){
                            new Noty({
                                    type:'alert',
                                    theme:'mint',
                                    text: 'Το λεπτό δεν μπορεί να είναι μεγαλύτερο από την διάρκεια της Αναμέτρησης',
                                    timeout: 2000
                                }).show();
                            $(this).focus();
                            return false;
                          }
                        if (kind != 'subs'){
                            player= $('#'+kind+'_team'+team+k).val();
                            if (team==1){
                             var result = $.grep(players1, function(e){ return e.num == parseInt(player); });
                            }else{
                            var result = $.grep(players2, function(e){ return e.num == parseInt(player); });    
                            }
                             var minIn=parseInt(result[0].in);
                             var minOut=parseInt(result[0].out);
                             if (!(min>=minIn && min<=minOut)){
                                new Noty({
                                    type:'alert',
                                    theme:'mint',
                                    text: 'Ο ποδοσφαιριστής δεν συμμετείχε στο λεπτό που αναφέρετε. Το γκολ μπήκε στο '+min+' και ο ποδοσφαιριστής μπήκε στο '+minIn+' και βγήκε στο '+minOut+' Ελέξτε ξανά!',
                                    timeout: 2000
                                }).show();
                            
                            return false;
                             }
                            }
                });
               yellow1=5;
               yellow2=5;
            $(document).on('click',".yellow-adder", function(){
                var team=$(this).attr('team');
                if (team==1)
                    yellow=yellow1;
                else
                    yellow=yellow2;
                $('#yellow_cards_team'+team+' tbody').append('<tr><td style="text-align:center;"><input type="text" size="2" class="form-control player_team'+team+' yellow'+team+'" team="'+team+'"  kind="yellow" id="yellow_team'+team+yellow+'" show_in="yellow_player'+team+yellow+'" yellow="'+yellow+'"></td><td id="yellow_player'+team+yellow+'">&nbsp;</td><td style="text-align:center;"><input type="text" class="form-control yellow_team'+team+' Min" kind="yellow" team="'+team+'" k="'+yellow+'" id="yellow_team'+team+'_min'+yellow+'" size="3"/></td></tr>');
                if(team==1)
                    yellow1++;
                else
                    yellow2++;
              });
            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

                    if (stepNumber==2){
                            $('input[type="text"][kind="sub"]').not('.Min').each(function(index, element){
                                          var cur=$(this);
                                           if ($.trim(cur.val()).length) {
                                                        var sub=cur.attr('sub');
                                                        var team=cur.attr('team');
                                                        if (team==1) {
                                                                      var sub_in= $('#sub_in_team1'+sub).val();
                                                                      var min=$('#sub_team1_min'+sub).val();
                                                                      
                                                                      var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                                      var player_out= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerOutID= temp[0];
                                                                      players1.forEach(function(f) {
                                                                                      if(f.num === parseInt(cur.val())) {
                                                                                        f.out = min;
                                                                                      }  
                                                                                    });
                                                                      var result = $.grep(players1, function(e){ return e.num == parseInt(sub_in); });
                                                                      var player_in= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerInID= temp[0];
                                                                      players1.forEach(function(f) {
                                                                                      if(f.num === parseInt(sub_in)) {
                                                                                        f.in = min;
                                                                                        f.out= parseInt(duration);
                                                                                      }  
                                                                                    });
                                                        }else{
                                                                      var sub_in= $('#sub_in_team2'+sub).val();
                                                                      var min=$('#sub_team2_min'+sub).val();
                                                                      
                                                                      var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                                      var player_out= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerOutID= temp[0];
                                                                      players2.forEach(function(f) {
                                                                                      if(f.num === parseInt(cur.val())) {
                                                                                        f.out = min;
                                                                                      }  
                                                                                    });
                                                                      var result = $.grep(players2, function(e){ return e.num == parseInt(sub_in); });
                                                                      var player_in= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerInID= temp[0];   
                                                                      players2.forEach(function(f) {
                                                                                      if(f.num === parseInt(sub_in)) {
                                                                                        f.in = min;
                                                                                        f.out= parseInt(duration);
                                                                                      }  
                                                                                    });
                                                        }
                                                     
                                                    }
                                                    
                                                });
                        
                     }
            });
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
                            
                     @if(config('settings.yellow'))
                        if (stepNumber==6){
                     @else
                        if (stepNumber==5){
                     @endif
                            for (var i=0;i<players1.length;i++){
                                console.log(players1[i].num+'-'+players1[i].in+'-'+players1[i].out);
                            }
                            for (var i=0;i<players2.length;i++){
                                console.log(players2[i].num+'-'+players2[i].in+'-'+players2[i].out);
                            }
                            var errorLog= new Array();
                            errorLog.length=0;
                            var warningLog= new Array();
                            warningLog.length=0;
                            $("#goal1").parent().parent().find("tr:gt(0)").html("");
                            $("#goal2").parent().parent().find("tr:gt(0)").html("");
                            $("#red1").parent().parent().find("tr:gt(0)").html("");
                            $("#red2").parent().parent().find("tr:gt(0)").html("");
                            @if(config('settings.yellow'))
                                $("#yellow1").parent().parent().find("tr:gt(0)").html("");
                                $("#yellow2").parent().parent().find("tr:gt(0)").html("");
                            @endif
                            $("#subs1").parent().parent().find("tr:gt(0)").html("");
                            $("#subs2").parent().parent().find("tr:gt(0)").html("");
                            if (players1.length<9)
                                errorLog.push('Οι ποδοσφαιριστές της Γηπεδούχου ομάδας είναι λιγότεροι από 9');
                            if (players2.length<9)
                                errorLog.push('Οι ποδοσφαιριστές της Φιλοξενούμενης ομάδας είναι λιγότεροι από 9');    
                            for (var i=0;i<players1.length;i++){
                                var temp=players1[i].player.split('-');
                                var player= temp[0];
                                var player1='<input type="hidden" name="player1['+i+']" value="'+player+'"/><input type="hidden" name="player1in['+i+']" value="'+players1[i].in+'"/><input type="hidden" name="player1out['+i+']" value="'+players1[i].out+'"/>';
                                 $('#playerTeam1-'+players1[i].num).html(players1[i].player+player1);                                        
                                        
                            }
                            for (var i=0;i<players2.length;i++){
                                var temp=players2[i].player.split('-');
                                var player= temp[0];
                                var player2='<input type="hidden" name="player2['+i+']" value="'+player+'"/><input type="hidden" name="player2in['+i+']" value="'+players2[i].in+'"/><input type="hidden" name="player2out['+i+']" value="'+players2[i].out+'"/>';
                                 $('#playerTeam2-'+players2[i].num).html(players2[i].player+player2);             
                            }
                             $('input[type="text"][kind="goal"]').not('.Min').each(function(index, element){
                                    
                                    var cur=$(this);
                                    if ($.trim(cur.val()).length) {
                                          
                                          var goal=cur.attr('goal');
                                          var team=cur.attr('team');
                                          var min=$('#goal_team'+team+'_min'+goal).val();
                                          if (!$.trim(min).length)
                                            errorLog.push('Στο γκολ του παίκτη της '+((team==1)?'Γηπεδούχου':'Φιλοξενούμενης')+' ομάδας με τον αριθμό '+$(this).val()+'δεν έχετε καταχωρήσει το λεπτό που σημειώθηκε');
                                          var own_goal= ($('#own_goal_team'+team+goal).is(':checked'))?'<i class="glyphicon glyphicon-ok"></i>':'<i class="glyphicon glyphicon-minus"></i>';
                                          var penalty= ($('#penalty_team'+team+goal).is(':checked'))?'<i class="glyphicon glyphicon-ok"></i>':'<i class="glyphicon glyphicon-minus"></i>';
                                          var own_goal_input= ($('#own_goal_team'+team+goal).is(':checked'))?1:0;
                                          var penalty_input= ($('#penalty_team'+team+goal).is(':checked'))?1:0;
                                          if (team==1){
                                          if ($('#own_goal_team1'+goal).is(":checked")) {
                                                          var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                          var player=result[0].player;
                                                          var temp=result[0].player.split('-');
                                                          var playerID= temp[0];
                                                          var minIn=parseInt(result[0].in);
                                                         var minOut=parseInt(result[0].out);
                                                         if (!(min>=minIn && min<=minOut)){
                                                            errorLog.push('Ο παίκτης της Φιλοξενούμενης ομάδας με τον αριθμό '+$(this).val()+' δεν συμμετείχε στο λεπτό που  έχετε καταχωρήσει το αυτογκόλ, που σημείωσε');
                                                            }

                                            }else{
                                                          var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                          var player=result[0].player;
                                                          var temp=result[0].player.split('-');
                                                          var playerID= temp[0];
                                                          var minIn=parseInt(result[0].in);
                                                         var minOut=parseInt(result[0].out);
                                                         if (!(min>=minIn && min<=minOut)){
                                                            errorLog.push('Ο παίκτης της Γηπεδούχου ομάδας με τον αριθμό '+$(this).val()+' δεν συμμετείχε στο λεπτό που έχετε καταχωρήσει το γκόλ, που σημείωσε');
                                                            }
                                            }
                                        }else{
                                              if ($('#own_goal_team2'+goal).is(":checked")) {
                                                          var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                          var player=result[0].player;
                                                          var temp=result[0].player.split('-');
                                                          var playerID= temp[0];
                                                          var minIn=parseInt(result[0].in);
                                                         var minOut=parseInt(result[0].out);
                                                         if (!(min>=minIn && min<=minOut)){
                                                            errorLog.push('Ο παίκτης της Γηπεδούχου ομάδας με τον αριθμό '+$(this).val()+' δεν συμμετείχε στο λεπτό που έχετε καταχωρήσει το αυτογκόλ, που σημείωσε');
                                                            }
                                            }else{
                                                          var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                          var player=result[0].player;
                                                          var temp=result[0].player.split('-');
                                                          var playerID= temp[0];
                                                          var minIn=parseInt(result[0].in);
                                                          var minOut=parseInt(result[0].out);
                                                          if (!(min>=minIn && min<=minOut)){
                                                            errorLog.push('Ο παίκτης της Φιλοξενούμενης ομάδας με τον αριθμό '+$(this).val()+' δεν συμμετείχε στο λεπτό που  έχετε καταχωρήσει το γκόλ, που σημείωσε');
                                                            }
                                            }   
                                        }
                                         var goal_input='<input type="hidden" name="scorer'+team+'['+goal+']" value="'+playerID+'"/><input type="hidden" name="goalMin'+team+goal+'" value="'+min+'"/><input type="hidden" name="goalOwn'+team+goal+'" value="'+own_goal_input+'"/><input type="hidden" name="penalty'+team+goal+'" value="'+penalty_input+'"/>';
                                          $('#goal'+team+' tr:last').after('<tr><td>'+cur.val()+'</td><td>'+player+'</td><td>'+min+'</td><td>'+own_goal+'</td><td>'+penalty+goal_input+'</td></tr>');
                                      }else{
                                        errorLog.push('Δεν έχετε καταχωρήσει όλα τα γκολ της Αναμέτρησης');
                                      }
                                        
                                      });
                             $('input[type="text"][kind="red"]').not('.Min').each(function(index, element){
                                          var cur=$(this);
                                          var red=cur.attr('red');
                                          var team=cur.attr('team');
                                    if ($.trim(cur.val()).length) {
                                          var min=$('#red_team'+team+'_min'+red).val();
                                          if (!$.trim(min).length)
                                            errorLog.push('Στην κόκκινη κάρτα του παίκτη της '+((team==1)?'Γηπεδούχου':'Φιλοξενούμενης')+' ομάδας με τον αριθμό '+$(this).val()+'δεν έχετε καταχωρήσει το λεπτό που σημειώθηκε');
                                          if(team==1){
                                                var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                var minIn=parseInt(result[0].in);
                                                var minOut=parseInt(result[0].out);
                                                if (!(min>=minIn && min<=minOut)){
                                                    warningLog.push('Ο παίκτης της Γηπεδούχου ομάδας με τον αριθμό '+$(this).val()+' δεν συμμετείχε στο λεπτό που έχετε καταχωρήσει την κόκκινη κάρτα');
                                                    }
                                            }else{
                                               var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); }); 
                                               var minIn=parseInt(result[0].in);
                                               var minOut=parseInt(result[0].out);
                                               if (!(min>=minIn && min<=minOut)){
                                                    warningLog.push('Ο παίκτης της Φιλοξενούμενης ομάδας με τον αριθμό '+$(this).val()+' δεν συμμετείχε στο λεπτό που έχετε καταχωρήσει την κόκκινη κάρτα');
                                                    }
                                            } 
                                          var player=result[0].player;
                                          var temp=result[0].player.split('-');
                                          var playerID= temp[0];
                                          var red_input='<input type="hidden" name="red'+team+'['+red+']" value="'+playerID+'"/><input type="hidden" name="redMin'+team+red+'" value="'+min+'"/>';
                                          $('#red'+team+' tr:last').after('<tr><td>'+cur.val()+'</td><td>'+player+'</td><td>'+min+red_input+'</td></tr>');
                                      }
                                        
                                      });
                            @if(config('settings.yellow'))
                             $('input[type="text"][kind="yellow"]').not('.Min').each(function(index, element){
                                          var cur=$(this);
                                          var yellow=cur.attr('yellow');
                                          var team=cur.attr('team');
                                    if ($.trim(cur.val()).length) {
                                          var min=$('#yellow_team'+team+'_min'+yellow).val();
                                          if (!$.trim(min).length)
                                            errorLog.push('Στην κίτρινη του παίκτη της '+((team==1)?'Γηπεδούχου':'Φιλοξενούμενης')+' ομάδας με τον αριθμό '+$(this).val()+' δεν έχετε καταχωρήσει το λεπτό που σημειώθηκε');
                                          if(team==1){
                                                var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                var minIn=parseInt(result[0].in);
                                                var minOut=parseInt(result[0].out);
                                                if (!(min>=minIn && min<=minOut)){
                                                    warningLog.push('Ο παίκτης της Γηπεδούχου ομάδας με τον αριθμό  '+$(this).val()+' δεν συμμετείχε στο λεπτό που έχετε καταχωρήσει την κίτρινη κάρτα');
                                                    }
                                            }else{
                                               var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); }); 
                                               var minIn=parseInt(result[0].in);
                                               var minOut=parseInt(result[0].out);
                                               if (!(min>=minIn && min<=minOut)){
                                                    warningLog.push('Ο παίκτης της Φιλοξενούμενης ομάδας με τον αριθμό  '+$(this).val()+' δεν συμμετείχε στο λεπτό που έχετε καταχωρήσει την κίτρινη κάρτα');
                                                    }
                                            } 
                                          var player=result[0].player;
                                          var temp=result[0].player.split('-');
                                          var playerID= temp[0];
                                          var yellow_input='<input type="hidden" name="yellow'+team+'['+yellow+']" value="'+playerID+'"/><input type="hidden" name="yellowMin'+team+yellow+'" value="'+min+'"/>';
                                          $('#yellow'+team+' tr:last').after('<tr><td>'+cur.val()+'</td><td>'+player+'</td><td>'+min+yellow_input+'</td></tr>');
                                      }
                                        
                                      });
                              @endif
                               $('input[type="text"][kind="sub"]').not('.Min').each(function(index, element){
                                          var cur=$(this);
                                           if ($.trim(cur.val()).length) {
                                                        var sub=cur.attr('sub');
                                                        var team=cur.attr('team');
                                                        if (team==1) {
                                                                      var sub_in= $('#sub_in_team1'+sub).val();
                                                                      var min=$('#sub_team1_min'+sub).val();
                                                                      var result = $.grep(players1, function(e){ return e.num == parseInt(cur.val()); });
                                                                      var player_out= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerOutID= temp[0];
                                                                      var result = $.grep(players1, function(e){ return e.num == parseInt(sub_in); });
                                                                      var player_in= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerInID= temp[0];
                                                                      
                                                        }else{
                                                                      var sub_in= $('#sub_in_team2'+sub).val();
                                                                      var min=$('#sub_team2_min'+sub).val();
                                                                      var result = $.grep(players2, function(e){ return e.num == parseInt(cur.val()); });
                                                                      var player_out= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerOutID= temp[0];
                                                                      var result = $.grep(players2, function(e){ return e.num == parseInt(sub_in); });
                                                                      var player_in= result[0].player;
                                                                      var temp=result[0].player.split('-');
                                                                      var playerInID= temp[0];   
                                                        }
                                                     var sub_input='<input type="hidden" name="subOut'+team+'['+sub+']" value="'+playerOutID+'"/><input type="hidden" name="subIn'+team+sub+'" value="'+playerInID+'"/><input type="hidden" name="subMin'+team+sub+'" value="'+min+'"/>';
                                                      $('#subs'+team+' tr:last').after('<tr><td>'+cur.val()+'</td><td>'+player_out+'</td><td>'+sub_in+'</td><td>'+player_in+'</td><td>'+min+sub_input+'</td></tr>');  
                                                    }
                                                });
                        if (errorLog.length===0){
                            $('#saveButton').prop('disabled', false);
                            $('#errorContainer').html('');
                            if (warningLog.length===0){
                                $('#warningContainer').html('');
                            }else{
                                var warningText='<div class="alert alert-warning">Έχετε '+warningLog.length+'  αναντιστοιχίες κατά την καταχώρηση του Φύλλου Αγώνα.<ul class="list-group">';
                                for (var i=0;i<warningLog.length;i++){
                                    warningText+='<li class="list-group-item" style="background:none;">'+warningLog[i]+'</li>';
                                    console.log(warningLog[i]);
                                }
                                warningText+='</ul></div>';
                                $('#warningContainer').html(warningText);
                            }
                        }else{
                            $('#saveButton').prop('disabled', true);

                            var errorText='<div class="alert alert-danger">Έχετε '+errorLog.length+' λάθη κατά την καταχώρηση του Φύλλου Αγώνα. Δεν μπορείτε να συνεχίσετε στην Αποθήκευση αν δεν τα διορθώσετε.<ul class="list-group">';
                            for (var i=0;i<errorLog.length;i++){
                                errorText+='<li class="list-group-item" style="background:none;">'+errorLog[i]+'</li>';
                                console.log(errorLog[i]);
                            }
                            errorText+='</ul></div>';
                            $('#errorContainer').html(errorText);
                        }
                        }
            });

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
              $(document).on('click','#insert_player', function(){
                                var old_team=$('#team_from').val();
                                var new_team=$('#team_to').val();
                                var player_id=$('#player_id').val();
                                var player_name=$('#player').val();
                                var fname= $('#F_name').val();
                                var team=$(this).attr('team');
                                                   
                            
                                $.ajax({url: "{{route('admin.move.transfer.do_st_insert')}}",
                                                    type: 'post',
                                                    beforeSend: function (xhr) {
                                                                var token = $('input[name="_token"]').val();
                                                                
                                                                if (token) {
                                                                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                                                                }
                                                            },
                                                    data: {'player_id': player_id,
                                                          'team_from': old_team,
                                                          'team_to': new_team
                                                    },
                                                    error: function (xhr, err) {
                                                                console.log(xhr.responseText);
                                                                exit();
                                                        },
                                                     success: function(data){
                                                                    if(data=='ok'){
                                                                           if (team==1) {
                                                                               var temp='<li id="'+player_id+'" class="list-group-item list-group-item-action move" style="cursor: pointer">'+player_id+'-'+player_name+' του '+fname+'</li>';
                                                                               $('#allItems').prepend(temp);     
                                                                           }else{
                                                                               var temp='<li id="'+player_id+'" class="list-group-item list-group-item-action move1" style="cursor: pointer">'+player_id+'-'+player_name+' του '+fname+'</li>';
                                                                               $('#allItems1').prepend(temp);     
                                                                           }
                                                                       }else{
                                                                           alert(data);
                                                                            }
                                                                $('#match-modal').modal('hide');                                
                                                                       
                                                    }
                                            });   
                                
              });

              $(document).on('click','#insert_new_player', function(){
                                var deltio=$('#np_player_id').val();
                                var surname=$('#np_playerSurname').val();
                                var name=$('#np_playerName').val();
                                var fname=$('#np_F_name').val();
                                var team=$('#np_team_to').val();
                                var wteam=$(this).attr('team');
                                alert(deltio+' '+surname+' '+name);
                                if (deltio=='' || surname=='' || name=='' || fname=='' || deltio==null || surname==null || name==null || fname==null ) {
                                                                alert('Λείπουν υποχρεωτικά πεδία. Παρακαλώ συμπληρώστε τα.');
                                                                return false;
                                }
                                                   
                            
                                $.ajax({url: "{{route('admin.file.players.do_st_insert')}}",
                                                    type: 'post',
                                                    beforeSend: function (xhr) {
                                                                var token = $('input[name="_token"]').val();
                                                                
                                                                if (token) {
                                                                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                                                                }
                                                            },
                                                    data: {'player_id': deltio,
                                                          'Lastname': surname,
                                                          'Firstname': name,
                                                          'Fname':fname,
                                                          'team':team
                                                    },
                                                    error: function (xhr, err) {
                                                                console.log(xhr.responseText);
                                                                exit();
                                                        },
                                                     success: function(data){
                                                                    if(data=='ok'){
                                                                           if (wteam==1) {
                                                                               var temp='<li id="'+deltio+'" class="list-group-item list-group-item-action move" style="cursor: pointer">'+deltio+'-'+surname+' '+name+' του '+fname+'</li>';
                                                                               $('#allItems').prepend(temp);     
                                                                           }else{
                                                                               var temp='<li id="'+deltio+'" class="list-group-item list-group-item-action move1" style="cursor: pointer">'+deltio+'-'+surname+' '+name+' του '+fname+'</li>';
                                                                               $('#allItems1').prepend(temp);     
                                                                           }
                                                                       }else{
                                                                           alert(data);
                                                                            }
                                                                $('#match-modal').modal('hide');                                
                                                                       
                                                    }
                                            });   
                                
              });
            $(document).on ('click', '.modal-trigger', function(){
                  id= $(this).attr('load');
                  var team=$(this).attr('team');
                  
                  
                  $.get(id).done(function(data){
                    console.log(data);
                      $('.modal-body').html(data);
                      $('#match-modal').appendTo('body').modal('show');
                      $('#insert_player').attr('team',team);
                      $('#insert_new_player').attr('team',team);
                  }
            );
      });  

        });
    </script>
@endsection
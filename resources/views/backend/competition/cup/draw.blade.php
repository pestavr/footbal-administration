@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Κύπελλο</small>
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
          @foreach ($groups as $group)
            <h4 class="box-title">Κλήρωση {{ $group->period }}- {{ $group->category }}- {{ $group->title }}</h4>
            <?php $nTeams=$group->omades ?>
          @endforeach  
           <div class="box-tools pull-right">

                @include('backend.competition.partials.cup-header-buttons')
            </div>
        </div><!-- /.box-header -->
        
          
        <div class="box-body">
            <div class="with-border">
            
     {{Form::open(['method' => 'post', 'route' => array( 'admin.competition.cup.saveMatches',$group->id)])}}               
                    {{ csrf_field() }}
                    <?php $i=0; ?>
                    @foreach ($teams as $team)
                    <?php $i++; ?>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ $team->teamName }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control key" id="key-{{ $i }}" team="{{ $team->id }}" teamName="{{ $team->teamName }}" name="team[{{ $team->id }}]" placeholder="Εισαγετε Κλειδάριθμο">
                        </div>
                      </div>
                      @endforeach 
                       <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Γύροι</label>
                          <div class="col-sm-10">
                          {!! Form::select('rounds', ['1'=>'Και οι δύο Γύροι','2'=> 'Πρώτος Γύρος','3'=> 'Δεύτερος Γύρος'] , '', ['class'=>'form-control']) !!}
                          <small id="Herbhelp" class="form-text text-muted">Επιλέξτε ποιοι γύροι θέλετε να συμπεριλαμβάνονται στο πρόγραμμα.</small>
                        </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Αυτόματη συμπλήρωση Γηπέδων:</label>
                          <div class="col-sm-10">
                          <input type="checkbox" name="fields">
                          <small id="Herbhelp" class="form-text text-muted">Στο πρόγραμμα θα συμπληρωθούν και τα γήπεδα, εφόσον έχουν ορισθεί τα γήπεδα γηπεδούχων.</small>
                        </div>
                      </div>
                      <div class="box-tools pull-left">
                          <button type="button" id="autoDraw" class="btn btn-info">Ηλεκτρονική Κλήρωση</button>
                      </div>
                      <div class="box-tools pull-right">
                          <button type="submit" id="show" class="btn btn-primary">Εισαγωγή Αναμετρήσεων</button>
                      </div>
                     
           {{Form::close()}}          
                   
            </div>
    </div><!--box-->

    <div class="box box-success">
        <div class="box-header with-border">
            Ανάπτυξη 
           
        </div><!-- /.box-header -->
        
          
        <div class="box-body">
            <div class="with-border">
                    {{ csrf_field() }}
              <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Γύρος</th>
                        <th>Αγωνιστική</th>
                        <th>Γηπεδούχος</th>
                        <th>Φιλοξενούμενος</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $i=0; 
                            $curMD=0; 
                      ?>
                      @foreach ($anaptixi as $an)
                      <?php 
                      if ($curMD!=$an->match_days){
                        $i=0;
                        $curMD=$an->match_days;
                      }
                      $i++; 
                      ?>
                      <tr>
                        <td>{{$an->round}}</td>
                        <td>{{$an->match_days}}</td>
                        <td><input type="text" class="form-control team" id="home-{{$an->round}}-{{$an->match_days}}-{{$i}}" name="home[]" value="{{ $an->home }}" readonly="readonly">
                          <input type="hidden" class="form-control teamID" id="home-{{$an->round}}-{{$an->match_days}}-{{$i}}-id" name="home-id[]" value="{{ $an->home }}" readonly="readonly"></td>
                        <td><input type="text" class="form-control team" id="away-{{$an->round}}-{{$an->match_days}}-{{$i}}" name="away[]" value="{{ $an->away }}" readonly="readonly">
                          <input type="hidden" class="form-control teamID" id="away-{{$an->round}}-{{$an->match_days}}-{{$i}}-id" name="away-id[]" value="{{ $an->away }}" readonly="readonly"></td>
                      </tr>
                      @endforeach 
                    </tbody>
                </table>
                 
            </div><!--table-responsive-->
         </div>
    </div><!--box-->  
    
    
        
@endsection

@section('after-scripts')
   
    {{ Html::script("//code.jquery.com/ui/1.11.2/jquery-ui.js") }}
    
    <script>

      $(function() {
          $("form").on("submit", function () {
                $(this).find(":submit").prop("disabled", true);
            });
          $( ".key" ).on('focusout',function(){
            var $key=$(this).val();
            $(".key").not(this).each(function(){
                if ($key==$(this).val() && $.isNumeric($key)){
                  alert('Έχετε ξαναεισάγει αυτόν τον κλειδάριθμο');
                  return false;
                }
            });
            if(($key>{{$group->omades}}) || $key<1){
                  alert('O κλειδάριθμος που εισάγατε δεν είναι έγκυρος');
                  return false;
            }
            var teamName=$(this).attr('teamName');
            var team=$(this).attr('team');
            $('#match-table input[value="'+$key+'"][type="text"]').each(function(){
                $(this).val(teamName);
            });
            $('#match-table input[value="'+$key+'"][type="hidden"]').each(function(){
                $(this).val(team);
            });

          });
          $( "#autoDraw" ).on('click',function(){
            $('.key').each(function(){
                $(this).val('');
            });
            for (var i=1;i<={{$nTeams}};i++){
             
                  var $input=Math.floor(Math.random() * {{$nTeams}}) + 1;
                  while ($("#key-"+$input).val()!=''){
                      $input=Math.floor(Math.random() * {{$nTeams}}) + 1;
                  } 
                  $("#key-"+$input).val(i);
                  var teamName=$("#key-"+$input).attr('teamName');
                  var team=$("#key-"+$input).attr('team');
                  $('#match-table input[value="'+i+'"][type="text"]').each(function(){
                      $(this).val(teamName);
                  });
                  $('#match-table input[value="'+i+'"][type="hidden"]').each(function(){
                      $(this).val(team);
                  });
                  //$(this).prop('disabled', true);
                
                
            }
            
          });
          /*$( ".team" ).on('focusout',function(){
            var id=$(this).attr('id');
            if ($.isNumeric($(this).val())){
              $(this).attr('value',$(this).val());
              $("#"+id+"-id").attr('value',$(this).val())
            }
          });*/
      });

    </script>
@endsection
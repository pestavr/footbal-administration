@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Πρωταθλήματα- Νέος Όμιλος Κατάταξης</small>
    </h1>
@endsection

@section('after-styles')

    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
   
@endsection

@section('content')
{!! Form::open(array('url' => route("admin.competition.championship.savePlayOffGroup"))) !!}
    <div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Δημιουργία Νέας Φάσης Πρωταθλήματος</h3>

            <div class="box-tools pull-right">
               @include('backend.competition.partials.championship-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                <?php $items= App\Models\Backend\champs::pluck('category', 'champ_id'); ?>
                    <div class="form-group">
                                <label for="iso">Κατηγορία*</label>
                                {!! Form::select('category',  $items, null, ['class'=>'form-control', 'id'=>'category', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Κατηγορία']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                                <label for="iso">Πλήθος Ομάδων*</label>
                                {!! Form::text('nTeams', '', ['class'=>'form-control', 'id'=>'nTeams', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                                <label for="iso">Όνομα Ομίλου*</label>
                                {!! Form::text('groupName', '', ['class'=>'form-control', 'id'=>'groupName', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="iso">Προβιβάζονται</label>
                                {!! Form::text('qualify', '0', ['class'=>'form-control', 'id'=>'qualify', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="iso">Υποβιβάζονται</label>
                                {!! Form::text('relegation', '0', ['class'=>'form-control', 'id'=>'relegation', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="iso">Μπαράζ Προβιβασμού</label>
                                {!! Form::text('q_mparaz', '0', ['class'=>'form-control', 'id'=>'q_mparaz', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="iso">Μπαράζ Υποβιβασμού</label>
                                {!! Form::text('r_mparaz', '0', ['class'=>'form-control', 'id'=>'r_mparaz', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-12">
                         <label for="iso">Ομάδες Ομίλου</label>
                        <div id="teams"></div>
                    </div>
            </div>  
           <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <CENTER><button type="submit" id="show" class="btn btn-primary">Αποθήκευση</button></CENTER>
                </div>
            </div>   
            
        </div><!-- /.box-body -->
    </div>
{!! Form::close() !!}
@endsection

@section('after-scripts')
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}

    <script>
        $(document).ready(function () {
            var category=1;
            var nTeams=0;
            $('#category').change(function(){
                category=$(this).val();
            });
            $("form").on("submit", function () {
                $(this).find(":submit").prop("disabled", true);
            });
            $('#nTeams').on('focusout',function(){
                nTeams=$(this).val();
                var $response='';
                for (var i = 1; i <= nTeams; i++) {
                    $response+='<div class="row">';
                        $response+='<div class="form-group">';
                            $response+='<div class="col-sm-6">';
                                $response+='<input type="text" name=team[] rel="'+i+'" class="form-group team" placeholder="Συμπληρώστε την ομάδα">';
                                $response+='<input type="hidden" name=team_id['+i+'] value="0" id="team_id'+i+'" class="form-group">';
                            $response+='</div>';
                            $response+='<div class="col-sm-6">';
                                $response+='<input type="text" name=points['+i+'] rel="team_id'+i+'" class="form-group team" value="0">';
                            $response+='</div>';
                        $response+='</div>';
                    $response+='</div>';

                }
                $('#teams').html($response); 
            });
           $(document).on('focus','.team',function(){
                $(this).autocomplete({
              source: function( request, response ) {
                                  $.ajax( {
                                    url: "{{ route('admin.file.team.getTeamsAutocomplete') }}",
                                    dataType: "json",
                                    data: {
                                      term: request.term,
                                      cat: category
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
                            var id=$(this).attr('rel');
                            $("#team_id"+id).val(ui.item.id);
                            $(this).val(ui.item.value);             
                          }
          });
           });
             

        });
    </script>
@endsection
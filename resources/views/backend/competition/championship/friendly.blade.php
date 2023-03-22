@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Νέα Φιλική Αναμέτρηση</small>
    </h1>
@endsection

@section('after-styles')

    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
   
@endsection

@section('content')
{!! Form::open(array('url' => route("admin.competition.championship.saveFriendlyMatches", config('default.friendly')))) !!}
    <div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Δημιουργία Νέων Φιλικών Αναμετρήσεων</h3>

            <div class="box-tools pull-right">
               @include('backend.competition.partials.championship-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?php $items= App\Models\Backend\groups::where('category','=',config('default.friendly'))->where('aa_period','=',session('season'))->pluck('title', 'aa_group'); ?>
                    <div class="form-group">
                                <label for="iso">Κατηγορία*</label>
                                {!! Form::select('category',  $items, null, ['class'=>'form-control', 'id'=>'category', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Είδος Αναμέτρησης']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                                <label for="iso">Πλήθος Αναμετρήσεων*</label>
                                {!! Form::text('nTeams', '', ['class'=>'form-control', 'id'=>'nTeams', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>                
            </div>
             <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Διπλές Αναμετρήσεις:</label>
                  <div class="col-sm-4">
                      <input type="checkbox" name="double">
                      <small id="Herbhelp" class="form-text text-muted">Οι αναμετρήσεις θα καταχωρηθούν διπλές (και στις δύο έδρες).</small>
                  </div>
              <div class="form-group row">    
                  <label class="col-sm-2 col-form-label">Αυτόματη συμπλήρωση Γηπέδων:</label>
                  <div class="col-sm-4">
                      <input type="checkbox" name="fields">
                      <small id="Herbhelp" class="form-text text-muted">Στο πρόγραμμα θα συμπληρωθούν και τα γήπεδα, εφόσον έχουν ορισθεί τα γήπεδα γηπεδούχων.</small>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-12">
                         <label for="iso">Αναμετρήσεις</label>
                        <div id="matches"></div>
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
            $('#phases').on('change', function(){
                $('#groupName').val($('#phases option:selected').text());
            })
            $("form").on("submit", function () {
                $(this).find(":submit").prop("disabled", true);
            });
            $('#nTeams').on('focusout',function(){
                nTeams=$(this).val();             
                $('#matches').load("{{ route('admin.competition.cup.cupInputs')}}", {nTeams: nTeams}); 
            });
           $(document).on('focus','.team',function(){
                $(this).autocomplete({
              source: function( request, response ) {
                                  $.ajax( {
                                    url: "{{ route('admin.file.team.getTeamsAutocomplete') }}",
                                    dataType: "json",
                                    data: {
                                      term: request.term,
                                      cat: category,
                                      all: true
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
                            $("#"+id).val(ui.item.id);
                            $(this).val(ui.item.value);             
                          }
          });
           });
             

        });
    </script>
@endsection
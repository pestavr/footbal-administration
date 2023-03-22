@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Χρονικό Κώλυμα Διαιτητή</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style(asset('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css'))}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
    {{ Html::style("https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css")}}
    
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Εισαγωγή Νέου Χρονικού Κωλύματος</h3>

           <div class="box-tools pull-right">

                @include('backend.kollimata.partials.time-kol-header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => 'admin.kollimata.time.do_insert'])}}
                
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="onoma_web">Διαιτητής</label>
                        <input type="text" class="form-control" id="referee" name="referee" >
                        <input type="hidden" class="form-control" id="ref_id" name="ref_id" >
                        
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <?php $items= [1=>'Μόνο μια φορά',2=>'Επαναλαμβανόμενα']; ?>
                             <label for="iso">Είδος</label>
                            <CENTER>{!! Form::select('kind',  $items, null, ['class'=>'form-control', 'id'=>'kind', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Είδος']) !!}</CENTER>
                        </div>
                      </div> 
                      <div class="row">
                        <div class="col-md-12">
                            <div id="kolyma" style="padding-top:20px">
                            </div>
                        </div>
                      </div>             

                      
                      <center><button type="submit" class="btn btn-primary" style="margin-top: 20px">Εισαγωγή</button></center>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    
    
        
@endsection

@section('after-scripts')
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.el.js")) }}
    {{ Html::script("//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js") }}
    
    <script>

      $(function() {
          $("#referee").autocomplete({
                          source: function( request, response ) {
                                              $.ajax( {
                                                url: "{{ route('admin.file.referees.getReferee') }}",
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
                            var match= $(this).attr('match');
                            var rel= $(this).attr('rel');
                            $('#ref_id').val(ui.item.id);  
                             }
                      });
          $('#kind').on('change',function(){
                kind=$(this).val();             
                $('#kolyma').load("{{ route('admin.kollimata.time.timeForms')}}", {kind: kind}); 
            });
    var $cur_date_time= '';
    $(document).on('focus','.form_datetime', function(){
                  
                            $(this).datetimepicker({
                                        language:  'el',
                                        format: "dd/mm/yyyy",
                                        autoclose: true,
                                        todayBtn: true,
                                        minView: 2,
                                        pickerPosition: "top-right"
                                        
                                    });
                            
                            });
      });
   $(document).on('click','.days', function(){
        var ch= !$(this).is(':checked');
        var rel= $(this).attr('rel');
        $('#compare-'+rel).prop('disabled', ch);
   });   
  $(document).on('change','.compare', function(){
        var val= $(this).val();
        var rel= $(this).attr('rel');
         if (val==0){
            $('#time-'+rel).prop('disabled', true);
         }
         if (val==1 || val==2){
            $('#time-'+rel).prop('disabled', false);
         }
  });

   $(document).on('focus','.time', function(){
                  
                            $(this).timepicker({
                                        timeFormat: 'H:mm'
                                    });
                            
                            });

    </script>
@endsection
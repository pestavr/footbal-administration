@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Κώλυμα Διαιτητή με κάποιες Ομάδες</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css")}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Εισαγωγή Νέου Κωλύματος</h3>

           <div class="box-tools pull-right">

                @include('backend.kollimata.partials.team-kol-header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => 'admin.kollimata.team.do_insert', 'files' => true])}}
                
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="onoma_web">Διαιτητής</label>
                        <input type="text" class="form-control" id="referee" name="referee" >
                        <input type="hidden" class="form-control" id="ref_id" name="ref_id" >
                        
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                             <label for="iso">Ομάδες με τις οποίες έχει κώλυμα</label>
                            <CENTER><select name="teams[]" multiple="multiple" id="teamSelect" class="form-control"></select></CENTER>
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
    {{ Html::script("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js") }}
    
    
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
          $('#teamSelect').select2({
                       placeholder: "Επιλέξτε τις Ομάδες που έχει κώλυμα",
                       minimumInputLength: 3,
                       maximumInputLength: 3,
                       ajax: {
                                url: '{{ route("admin.file.team.getTeamsPerAgeLevel") }}',
                                dataType: 'json',
                                delay: 500,
                                data: function (params) {
                                      var query = {
                                        search: params.term,
                                        cat: 1
                                      }

                                      // Query parameters will be ?search=[term]&type=public
                                      return query;
                                    },
                                processResults: function (data) {
                                        return {
                                            results: data
                                        };
                                    },
                                 params: {
                                        error: function(response) {
                                            alert("error fetching data"); 
                                        }
                                    },
                                    cache: true
                              },
                        allowClear: true
                     });
      });

    </script>
@endsection
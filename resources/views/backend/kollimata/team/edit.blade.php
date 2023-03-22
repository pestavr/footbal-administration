@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Κώλυμα Διαιτητή με κάποιες Ομάδες</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
          @foreach ($referees as $referee)
            <h3 class="box-title">Επεξεργασία Κωλύματος του Διαιτητή {{ $referee->refLast }} {{ $referee->refFirst }}</h3>
          @endforeach
           <div class="box-tools pull-right">

                @include('backend.includes.partials.team-header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => array('admin.file.team.update',$referee->id)])}}
                
                    {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-12">
                         <label for="iso">Ομάδες Ομίλου</label>
                        <CENTER><select name="teams[]" multiple="multiple" id="teamSelect" class="form-control"></select></CENTER>
                    </div>
                  </div> 
              <center><button type="submit" class="btn btn-primary">Update</button></center>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    
    
        
@endsection

@section('after-scripts')
   
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js") }}
    
    <script>

      $(function() {
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
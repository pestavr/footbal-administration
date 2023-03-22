@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Γήπεδα</small>
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
            <h3 class="box-title">Επεξεργασία Γηπέδου</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.court-header-buttons')
            </div>
        </div><!-- /.box-header -->
        @foreach ($courts as $court)
        
        <div class="box-body">
            <div class="with-border">
              <h4>{{ $court->sort_name }}</h4>
                <form method="POST" action="{{ route('admin.file.court.mapupdate', $court->id) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude"  value="{{ $court->latitude }}" readonly>
                        
                      </div>
                      <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude"  value="{{ $court->longitude}}" readonly>
                        
                      </div>

                      <div class="form-group">
                        <label for="zoom">zoom</label>
                        <input type="text" class="form-control" id="zoom" name="zoom"  value="{{ $court->zoom}}" readonly>
                        
                      </div>
                      
                      <div style="width: 500px; height: 500px;">
                          {!! Mapper::render() !!}
                        </div>
                        Σύρετε τον δείκτη στο σημείο που βρίσκεται ο χάρτης. Ρυθμίστε στο επιθυμητό σημείο το Zoom. Πατήστε Ενημέρωση.
                        <br/>
                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    </form>
            </div>
    </div><!--box-->
  </div>
    @endforeach
    
        
@endsection

@section('after-scripts')
    
    {{ Html::script("//code.jquery.com/ui/1.11.2/jquery-ui.js") }}
    
    <script>

      $(function() {
          $( "#Bdate" ).datepicker({
            format: 'd/m/Y'
          });
      });

    </script>
@endsection
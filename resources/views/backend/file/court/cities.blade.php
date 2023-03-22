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
              <h4>Γήπεδο: {{ $court->sort_name }}</h4>
                <form method="POST" action="{{ route('admin.file.court.citiesupdate', $court->id) }}">
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="Kms"><h4>{{ $court->city }}</h4></label>
                        <input type="text" class="form-control" id="Kms" name="Kms" placeholder="Απόσταση"  aria-describedby="Kmshelp" value="{{ $court->Kms }}">
                        <small id="Kmshelp" class="form-text text-muted">Απόσταση σε χλμ</small>
                        <input type="text" class="form-control" id="diodia" name="diodia" placeholder="Διόδια" aria-describedby="Diodiahelp" value="{{ $court->diodia }}">
                        <small id="Diodiahelp" class="form-text text-muted">Διόδια σε €€.λλ</small>
                      </div>
                      @if($court->city2!='')
                      <div class="form-group">
                        <label for="Kms"><h4>{{ $court->city2 }}</h4></label>
                        <input type="text" class="form-control" id="Kms2" name="Kms2" placeholder="Απόσταση" aria-describedby="Kms2help" value="{{ $court->Kms2 }}">
                        <small id="Kms2help" class="form-text text-muted">Απόσταση σε χλμ</small>
                        <input type="text" class="form-control" id="diodia2" name="diodia2" placeholder="Διόδια" aria-describedby="Diodia2help" value="{{ $court->diodia2 }}">
                        <small id="Diodia2help" class="form-text text-muted">Διόδια σε €€.λλ</small>
                      </div>
                      @endif
                      @if($court->city3!='')
                      <div class="form-group">
                        <label for="Kms"><h4>{{ $court->city3 }}</h4></label>
                        <input type="text" class="form-control" id="Kms3" name="Kms3" placeholder="Απόσταση" aria-describedby="Kms3help" value="{{ $court->Kms3 }}">
                        <small id="Kms3help" class="form-text text-muted">Απόσταση σε χλμ</small>
                        <input type="text" class="form-control" id="diodia3" name="diodia3" placeholder="Διόδια" aria-describedby="Diodia3help" value="{{ $court->diodia3 }}">
                        <small id="Diodia3help" class="form-text text-muted">Διόδια σε €€.λλ</small>
                      </div>
                      @endif
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
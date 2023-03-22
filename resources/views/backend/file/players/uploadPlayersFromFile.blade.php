@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ποδοσφαιριστές</small>
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
            <h3 class="box-title">Ανέβασμα Ποδοσφαιριστών από αρχείο</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.players-header-buttons')
            </div>
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
                {{Form::open(['method' => 'post', 'route' => array('admin.file.players.doUploadPlayersFromFile'), 'files' => true])}}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Αρχείο</label>
                        {{Form::file('csv_file')}}
                        <small id="Herbhelp" class="form-text text-muted">Εισάγετε αρχείο csv με τους ποδοσφαιριστές (Αρ. Δελτίου-Όνομα-Επώνυμο-Ημερομηνία Γέννησης- Αρ. Μητρώου ΕΠΟ Ομάδας)</small>
                    </div>                    
                    <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                {{Form::close()}}
            </div>
    </div><!--box-->
  </div>
   
    
        
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
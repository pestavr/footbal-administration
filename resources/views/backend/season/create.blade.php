@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Αγωνιστική Περίοδος</small>
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
            <h3 class="box-title">Δημιουργία Νέας Αγωνιστικής Περιόδου</h3>

           <div class="box-tools pull-right">

               Η Αγωνιστική Περίοδος που θα δημιουργήσετε θα τεθεί ως τρέχουσα και η προηγούμενη θα κλείσει και οι εγγραφές της θα κλειδώσουν
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.season.insert') }}">
                    {{ csrf_field() }}
                    <?php $date=\Carbon\Carbon::now(); 
                          $thisYear=$date->year;
                          $nextYear=$date->addYear()->year;?>
                      <div class="form-group">
                        <label for="period">Όνομα Αγωνιστικής Περιόδου</label>
                        <input type="text" class="form-control" id="period" name="period"  value="Αγωνιστική Περίοδος {{ $thisYear }}-{{ $nextYear }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="enarxi">Ημερομηνία Έναρξης</label>
                        <input type="text" class="form-control" id="enarxi" name="enarxi" placeholder="ηη/μμ/ΕΕΕΕ" value="01/08/{{ $thisYear }}" readonly="readonly">
                      </div>
                       <div class="form-group">
                        <label for="lixi">Ημερομηνία Λήξης</label>
                        <input type="text" class="form-control" id="lixi" name="lixi" placeholder="ηη/μμ/ΕΕΕΕ" value="31/07/{{ $nextYear }}" readonly="readonly">
                      </div>
                      
                       <div class="form-group">
                          <center><button type="submit" class="btn btn-primary">Δημιουργία</button></center>
                        </div>
                    </form>
            </div>
    </div><!--box-->
    
    
        
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
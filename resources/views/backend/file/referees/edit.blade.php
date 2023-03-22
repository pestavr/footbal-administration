@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Διαιτητές</small>
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
            <h3 class="box-title">Επεξεργασία Διαιτητή</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.referies-header-buttons')
            
        </div><!-- /.box-header -->
        @foreach ($referees as $referee)
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.file.referees.update', $referee->id) }}">
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="exampleInputEmail1">Επώνυμο</label>
                        <input type="text" class="form-control" id="Lastname" name="Lastname" aria-describedby="Herbhelp" value="{{ $referee->Lastname }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Firstname">Όνομα</label>
                        <input type="text" class="form-control" id="Firstname" name="Firstname" value="{{ $referee->Firstname }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Fname">Όνομα Πατέρα</label>
                        <input type="text" class="form-control" id="Fname" name="Fname" value="{{ $referee->Fname }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Bdate">Ημερομηνία Γέννησης</label>
                        <?php $Bdate=\Carbon\Carbon::parse($referee->Bdate);
                              $defaultDate= \Carbon\Carbon::parse(config('default.datetime')); 
                          ?>
                        <input type="text" class="form-control" id="Bdate" name="Bdate" placeholder="ηη/μμ/ΕΕΕΕ" value="{{ (($Bdate->eq($defaultDate))?'':$Bdate->format('d/m/Y')) }}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $referee->address }}">
                       
                      </div>
                      <div class="form-group">
                        <label for="city">Πόλη</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $referee->city }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk" value="{{ $referee->tk }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="tel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="tel" name="tel" value="{{ $referee->tel }}">
                        <small id="isohelp" class="form-text text-muted">Το τηλέφωνο στο οποίο θα αποστέλλονται οι ειδοποιήσεις.</small>
                      </div>
                      <div class="form-group">
                        <label for="e-mail">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $referee->email }}">
                        
                      </div>
                      @if (config('settings.cities'))
                      <div class="form-group">
                        <label for="startpoint">Πόλη Διαμονής</label>
                        {!! Form::select('startpoint', ['0'=>'Επιλέξτε πόλη διαμονής','1'=> 'Πάτρα','2'=> 'Αίγιο','3'=> 'Κ. Αχαΐα'] , $referee->startpoint, ['class'=>'form-control']) !!}
                      </div>
                      @endif

                      
                      <button type="submit" class="btn btn-primary">Update</button>
                    </form>
            </div>
    </div><!--box-->
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
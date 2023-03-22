@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Υγειονομικοί </small>
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
            <h3 class="box-title">Επεξεργασία Ποδοσφαιριστή</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.doctor-header-buttons')
            </div>
        </div><!-- /.box-header -->
        @foreach ($doctors as $doctor)
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.file.doctor.update', $doctor->id) }}">
                    {{ csrf_field() }}
                     <div class="form-group">
                        <label for="exampleInputEmail1">Επώνυμο</label>
                        <input type="text" class="form-control" id="docLastName" name="docLastName" value="{{ $doctor->docLastName }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="docFirstName">Όνομα</label>
                        <input type="text" class="form-control" id="docFirstName" name="docFirstName" value="{{ $doctor->docFirstName }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Fname">Όνομα Πατέρα</label>
                        <input type="text" class="form-control" id="Fname" name="Fname" value="{{ $doctor->Fname }}">
                        
                      </div>
                    
                      <div class="form-group">
                        <label for="Address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="Address" name="Address" value="{{ $doctor->Address }}">
                       
                      </div>
                      <div class="form-group">
                        <label for="city">Πόλη</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $doctor->city }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk" value="{{ $doctor->tk }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="docTel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="docTel" name="docTel" value="{{ $doctor->docTel }}">
                        <small id="isohelp" class="form-text text-muted">Το τηλέφωνο στο οποίο θα αποστέλλονται οι ειδοποιήσεις.</small>
                      </div>
                      <div class="form-group">
                        <label for="docTel2">Δεύτερο Τηλέφωνο</label>
                        <input type="text" class="form-control" id="docTel2" name="docTel2" value="{{ $doctor->docTel2 }}">
                      </div>
                      <div class="form-group">
                        <label for="e-mail">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $doctor->email }}">
                        
                      </div>                

                      
                      

                      
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
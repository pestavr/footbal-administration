@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Παρατηρητές </small>
    </h1>
@endsection

@section('after-styles')

    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Εισαγωγή Νέου Παρατηρητή </h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.observer-header-buttons')
            
          </div><!-- /.box-header -->
        </div>
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.file.observer.do_insert') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Επώνυμο</label>
                        <input type="text" class="form-control" id="waLastName" name="waLastName" aria-describedby="Herbhelp" >
                        
                      </div>
                      <div class="form-group">
                        <label for="waFirstName">Όνομα</label>
                        <input type="text" class="form-control" id="waFirstName" name="waFirstName">
                        
                      </div>
                      <div class="form-group">
                        <label for="Fname">Όνομα Πατέρα</label>
                        <input type="text" class="form-control" id="Fname" name="Fname" >
                        
                      </div>
                    
                      <div class="form-group">
                        <label for="Address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="Address" name="Address" >
                       
                      </div>
                      <div class="form-group">
                        <label for="city">Πόλη</label>
                        <input type="text" class="form-control" id="city" name="city" >
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk" >
                        
                      </div>
                      <div class="form-group">
                        <label for="waTel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="waTel" name="waTel" >
                        <small id="isohelp" class="form-text text-muted">Το τηλέφωνο στο οποίο θα αποστέλλονται οι ειδοποιήσεις.</small>
                      </div>
                      <div class="form-group">
                        <label for="waTel2">Δεύτερο Τηλέφωνο</label>
                        <input type="text" class="form-control" id="waTel2" name="waTel2" >
                      </div>
                      <div class="form-group">
                        <label for="e-mail">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" >
                        
                      </div>                

                      
                      <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                    </form>
            </div>
    </div><!--box-->
    
</div>
        
@endsection

@section('after-scripts')
    
    {{ Html::script("//code.jquery.com/ui/1.11.2/jquery-ui.js") }}
    
    <script>

      jQuery(function() {
          jQuery( "#Bdate" ).datepicker({
            format: 'd/m/Y'
          });
      });

    </script>
@endsection
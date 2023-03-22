@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Γήπεδα</small>
    </h1>
@endsection

@section('after-styles')

    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Εισαγωγή Νέου Γηπέδου</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.court-header-buttons')
            
          </div><!-- /.box-header -->
        </div>
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.file.court.do_insert') }}">
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="eps_name">Όνομα</label>
                        <input type="text" class="form-control" id="eps_name" name="eps_name">
                        
                      </div>
                      <div class="form-group">
                        <label for="fild">Είδος Τεραίν</label>
                        {!! Form::select('fild', ['0'=>'Επιλέξτε Είδος','Συνθετικός Χλοοτάπητας'=> 'Συνθετικός Χλοοτάπητας','Φυσικός Χλοόταπητας'=> 'Φυσικός Χλοόταπητας','Χωμάτινο'=> 'Χωμάτινο'] , null , ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="apoditiria">Αποδυτήρια</label>
                        {!! Form::select('apoditiria', ['0'=>'Επιλέξτ','1'=> 'Ναι','2'=> 'Όχι'] , null , ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="Sheets">Θέσεις Καθήμενων</label>
                        <input type="text" class="form-control" id="Sheets" name="Sheets" >
                        
                      </div>
                      <div class="form-group">
                        <label for="address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="address" name="address"  >
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk"  >
                        
                      </div>
                      <div class="form-group">
                        <label for="region">Περιοχή</label>
                        <input type="text" class="form-control" id="region" name="region"  >
                        
                      </div>
                      <div class="form-group">
                        <label for="town">Πόλη</label>
                        <input type="text" class="form-control" id="town" name="town"  >
                        
                      </div>
                      <div class="form-group">
                        <label for="tel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="tel" name="tel"  >
                        
                      </div>
                      <div class="form-group">
                        <label for="fax">Fax</label>
                        <input type="text" class="form-control" id="fax" name="fax" >
                        
                      </div>
                      <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" id="email" name="email" >
                        
                      </div>
                      <div class="form-group">
                        <label for="administrator">Υπεύθυνος Γηπέδου</label>
                        <input type="text" class="form-control" id="administrator" name="administrator" >
                        
                      </div>
                      <div class="form-group">
                        <label for="tel_admin">Τηλέφωνο Υπευθύνου</label>
                        <input type="text" class="form-control" id="tel_admin" name="tel_admin" > 
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
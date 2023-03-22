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
                <form method="POST" action="{{ route('admin.file.court.update', $court->id) }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="eps_name">Όνομα</label>
                        <input type="text" class="form-control" id="eps_name" name="eps_name"  value="{{ $court->sort_name }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="fild">Είδος Τεραίν</label>
                        {!! Form::select('fild', ['0'=>'Επιλέξτε Είδος','Συνθετικός Χλοοτάπητας'=> 'Συνθετικός Χλοοτάπητας','Φυσικός Χλοόταπητας'=> 'Φυσικός Χλοόταπητας','Χωμάτινο'=> 'Χωμάτινο'] , $court->fild , ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="apoditiria">Αποδυτήρια</label>
                        {!! Form::select('apoditiria', ['0'=>'Επιλέξτ','1'=> 'Ναι','2'=> 'Όχι'] , $court->apoditiria , ['class'=>'form-control']) !!}
                        
                      </div>
                      @if (!config('settings.cities') && !config('settings.google'))
                      <div class="form-group">
                        <label for="Kms">Απόσταση από Πρωτεύουσα Νομού</label>
                        <input type="text" class="form-control" id="Kms" name="Kms" value="{{ $court->Kms}}">
                        
                      </div>
                      @endif
                      <div class="form-group">
                        <label for="Sheets">Θέσεις Καθήμενων</label>
                        <input type="text" class="form-control" id="Sheets" name="Sheets" value="{{ $court->Sheets}}">
                        
                      </div>
                      <div class="form-group">
                        <label for="address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $court->address }}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk"  value="{{ $court->tk }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="region">Περιοχή</label>
                        <input type="text" class="form-control" id="region" name="region"  value="{{ $court->region }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="town">Πόλη</label>
                        <input type="text" class="form-control" id="town" name="town"  value="{{ $court->town }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="tel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="tel" name="tel"  value="{{ $court->tel }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="fax">Fax</label>
                        <input type="text" class="form-control" id="fax" name="fax"  value="{{ $court->fax }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" id="email" name="email"  value="{{ $court->email }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="administrator">Υπεύθυνος Γηπέδου</label>
                        <input type="text" class="form-control" id="administrator" name="administrator"  value="{{ $court->administrator }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="tel_admin">Τηλέφωνο Υπευθύνου</label>
                        <input type="text" class="form-control" id="tel_admin" name="tel_admin"  value="{{ $court->tel_admin }}"> 
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
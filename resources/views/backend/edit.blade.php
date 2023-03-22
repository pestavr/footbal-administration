@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small></small>
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
            <h3 class="box-title">Επεξεργασία Στοιχείων Ένωσης Ποδοσφαιρικών Σωματείων</h3>

           <div class="box-tools pull-right">
            </div>
        </div><!-- /.box-header -->
        @foreach ($eps as $ep)
        <div class="box-body">
            <div class="with-border">
                {{Form::open(['method' => 'post', 'route' => array('admin.update',$ep->eps_id), 'files' => true])}}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="logo">Λογότυπο</label>
                        @if (strlen($ep->logo)>0)
                        <img src="{{ $ep->logo }}" class="img-thumbnail" style="max-width: 200px; height: auto;"/>
                        @endif
                        {{Form::file('logo')}}
                      </div>
                     <div class="form-group">
                        <label for="name">Πλήρες Όνομα</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $ep->name }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="short_name">Όνομα</label>
                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ $ep->short_name }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="acronym">Ακρωνύμιο</label>
                        <input type="text" class="form-control" id="acronym" name="acronym" value="{{ $ep->acronym }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="etos_idrisis">Έτος Ίδρυσης</label>
                        <input type="text" class="form-control" id="etos_idrisis" name="etos_idrisis" value="{{ $ep->etos_idrisis }}">
                        
                      </div>
                    
                      <div class="form-group">
                        <label for="address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $ep->address }}">
                       
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk" value="{{ $ep->tk }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="district">Περιοχή</label>
                        <input type="text" class="form-control" id="district" name="district" value="{{ $ep->district }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="city">Πόλη</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $ep->city }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="county">Νομός</label>
                        <input type="text" class="form-control" id="county" name="county" value="{{ $ep->county }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="region">Περιφέρεια</label>
                        <input type="text" class="form-control" id="region" name="region" value="{{ $ep->region }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="tel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="tel" name="tel" value="{{ $ep->tel }}">
                      </div>
                      <div class="form-group">
                        <label for="tel2">Δεύτερο Τηλέφωνο</label>
                        <input type="text" class="form-control" id="tel2" name="tel2" value="{{ $ep->tel2 }}">
                      </div>
                      <div class="form-group">
                        <label for="fax">Fax</label>
                        <input type="text" class="form-control" id="fax" name="fax" value="{{ $ep->fax }}">
                        
                      </div>       
                      <div class="form-group">
                        <label for="e-mail">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $ep->email }}">
                        
                      </div> 
                      <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input type="text" class="form-control" id="facebook" name="facebook" value="{{ $ep->facebook }}">
                        
                      </div>              
                      <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="text" class="form-control" id="twitter" name="twitter" value="{{ $ep->twitter }}">
                        
                      </div>
                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    {{Form::close()}}
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
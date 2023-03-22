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
            <h3 class="box-title">Εισαγωγή Νέου Σωματείου</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.team-header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => 'admin.file.team.do_insert', 'files' => true])}}
                
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="onoma_web">Επώνυμία</label>
                        <input type="text" class="form-control" id="onoma_web" name="onoma_web" >
                        
                      </div>
                      <div class="form-group">
                        <label for="onoma_web">Έμβλημα</label>
                        {{Form::file('emblem')}}
                      </div>
                       <div class="form-group">
                        <label for="city">Ανήκει</label>
                        <?php $teams= App\Models\Backend\team::where('age_level','=', 1)->orderBy('onoma_web', 'asc')->pluck('onoma_web', 'team_id');   $teams->prepend('Επιλέξτε Ομάδα στην οποία ανήκει', 0);
                        ?>
                        {!! Form::select('parent', $teams, null, ['class'=>'form-control']) !!}
                        
                      </div>
                      
                      <div class="form-group">
                        <label for="Firstname">Ηλικιακή Κατηγορία</label>
                        <?php $items= App\Models\Backend\age_level::selectRaw('CONCAT(Age_Level_Title, " - ", Title) as ageLevels, id')->pluck('ageLevels', 'id');  ?>
                        {!! Form::select('age_level', $items, null, ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="etos_idrisis">Έτος Ίδρυσης</label>
                        <input type="text" class="form-control" id="etos_idrisis" name="etos_idrisis">
                        
                      </div>
                      <div class="form-group">
                        <label for="aa_epo">ΑΜ ΕΠΟ</label>
                        <input type="text" class="form-control" id="aa_epo" name="aa_epo"  >
                        
                      </div>
                      <div class="form-group">
                        <label for="code_gga">ΑΜ ΓΓΑ</label>
                        <input type="text" class="form-control" id="code_gga" name="code_gga" >
                        
                      </div>
                      <div class="form-group">
                        <label for="afm">ΑΦΜ</label>
                        <input type="text" class="form-control" id="afm" name="afm" >
                       
                      </div>
                      <div class="form-group">
                        <label for="city">Έδρα</label>
                        <?php $courts= App\Models\Backend\court::orderBy('sort_name', 'asc')->pluck('sort_name', 'aa_gipedou');  
                          $courts->prepend('Επιλέξτε Γήπεδο', config('default.court'));
                        ?>
                        {!! Form::select('court', $courts, null, ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">Εναλλακτική Έδρα</label>
                        {!! Form::select('court2', $courts, null, ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="address" name="address" >
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk" >
                      </div>
                      <div class="form-group">
                        <label for="region">Περιοχή</label>
                        <input type="text" class="form-control" id="region" name="region" >
                      </div>
                      <div class="form-group">
                        <label for="city">Πόλη</label>
                        <input type="text" class="form-control" id="city" name="city" >
                      </div>
                      <div class="form-group">
                        <label for="tel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="tel" name="tel" >
                      </div>
                      <div class="form-group">
                        <label for="smstel">Κινητό Τηλέφωνο</label>
                        <input type="text" class="form-control" id="smstel" name="smstel">
                      </div>
                      <div class="form-group">
                        <label for="fax">Fax</label>
                        <input type="text" class="form-control" id="fax" name="fax" >
                      </div>
                      <div class="form-group">
                        <label for="site">Site</label>
                        <input type="text" class="form-control" id="site" name="site" >
                      </div>
                      <div class="form-group">
                        <label for="e-mail">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" >
                        
                      </div>
                      

                      
                      <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                    {{Form::close()}}
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
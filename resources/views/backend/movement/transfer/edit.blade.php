@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Σωματεία</small>
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
            <h3 class="box-title">Επεξεργασία Σωματείου</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.team-header-buttons')
            
        </div><!-- /.box-header -->
        @foreach ($teams as $team)
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => array('admin.file.team.update',$team->id), 'files' => true])}}
                
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="onoma_web">Επώνυμία</label>
                        <input type="text" class="form-control" id="onoma_web" name="onoma_web" aria-describedby="Herbhelp" value="{{ $team->onoma_web }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="city">Ανήκει</label>
                        <?php $teams= App\Models\Backend\team::where('age_level','=', 1)->orderBy('onoma_web', 'asc')->pluck('onoma_web', 'team_id');   $teams->prepend('Επιλέξτε Ομάδα στην οποία ανήκει', 0);
                        ?>
                        {!! Form::select('parent', $teams, $team->parent, ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="onoma_web">Έμβλημα</label>
                        @if (strlen($team->emblem)>0)
                        <img src="{{ $team->emblem }}" class="img-thumbnail" style="max-width: 200px; height: auto;"/>
                        @endif
                        {{Form::file('emblem')}}
                      </div>

                      
                      <div class="form-group">
                        <label for="Firstname">Ηλικιακή Κατηγορία</label>
                        <?php $items= App\Models\Backend\age_level::selectRaw('CONCAT(Age_Level_Title, " - ", Title) as ageLevels, id')->pluck('ageLevels', 'id');  ?>
                        {!! Form::select('age_level', $items, $team->age_level, ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="etos_idrisis">Έτος Ίδρυσης</label>
                        <input type="text" class="form-control" id="etos_idrisis" name="etos_idrisis" value="{{ $team->etos_idrisis }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="aa_epo">ΑΜ ΕΠΟ</label>
                        <input type="text" class="form-control" id="aa_epo" name="aa_epo" value="{{ $team->aa_epo}}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="code_gga">ΑΜ ΓΓΑ</label>
                        <input type="text" class="form-control" id="code_gga" name="code_gga" value="{{ $team->code_gga}}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="afm">ΑΦΜ</label>
                        <input type="text" class="form-control" id="afm" name="afm" value="{{ $team->afm }}">
                       
                      </div>
                      <div class="form-group">
                        <label for="city">Έδρα</label>
                        <?php $courts= App\Models\Backend\court::pluck('sort_name', 'aa_gipedou');  ?>
                        {!! Form::select('court', $courts, $team->court, ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">Εναλλακτική Έδρα</label>
                        {!! Form::select('court2', $courts, $team->court2, ['class'=>'form-control']) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $team->address }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="tk">ΤΚ</label>
                        <input type="text" class="form-control" id="tk" name="tk" value="{{ $team->tk }}">
                      </div>
                      <div class="form-group">
                        <label for="region">Περιοχή</label>
                        <input type="text" class="form-control" id="region" name="region" value="{{ $team->region }}">
                      </div>
                      <div class="form-group">
                        <label for="city">Πόλη</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $team->city }}">
                      </div>
                      <div class="form-group">
                        <label for="tel">Τηλέφωνο</label>
                        <input type="text" class="form-control" id="tel" name="tel" value="{{ $team->tel }}">
                      </div>
                      <div class="form-group">
                        <label for="smstel">Κινητό Τηλέφωνο</label>
                        <input type="text" class="form-control" id="smstel" name="smstel" value="{{ $team->smstel }}">
                      </div>
                      <div class="form-group">
                        <label for="fax">Fax</label>
                        <input type="text" class="form-control" id="fax" name="fax" value="{{ $team->fax }}">
                      </div>
                      <div class="form-group">
                        <label for="site">Site</label>
                        <input type="text" class="form-control" id="site" name="site" value="{{ $team->site }}">
                      </div>
                      <div class="form-group">
                        <label for="e-mail">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $team->email }}">
                        
                      </div>
                      
                      

                      
                      <button type="submit" class="btn btn-primary">Update</button>
                    {{Form::close()}}
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
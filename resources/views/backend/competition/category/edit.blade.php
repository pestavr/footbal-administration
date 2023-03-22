@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Κατηγορίες</small>
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
            <h3 class="box-title">Επεξεργασία Κατηγορίας</h3>

           <div class="box-tools pull-right">

                @include('backend.competition.partials.category-header-buttons')
            
        </div><!-- /.box-header -->
        @foreach ($category as $cat)
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => array('admin.competition.category.update',$cat->id), 'files' => true])}}
                
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="category">Όνομα</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{ $cat->category }}">
                        
                      </div>
                    <?php $items= App\Models\Backend\age_level::selectRaw('id, CONCAT(Age_Level_Title, "-", Title) as name')->pluck('name', 'id'); ?>
                    <div class="form-group">
                                <label for="iso">Ηλικιακό Επίπεδο*</label>
                                {!! Form::select('age_level',  $items, $cat->age_level, ['class'=>'form-control', 'id'=>'age_level', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Ηλικιακό Επίπεδο']) !!}
                    </div>
                      <div class="form-group">
                        <label for="logo">Λογότυπο</label>
                        @if (strlen($cat->logo)>0)
                        <img src="{{ $cat->logo }}" class="img-thumbnail" style="max-width: 200px; height: auto;"/>
                        @endif
                        {{Form::file('logo')}}
                      </div>
                      <div class="form-group">
                        <label for="ref">Αμοιβή Διαιτητή</label>
                        <input type="text" class="form-control" id="ref" name="ref" value="{{ $cat->ref }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="hel">Αμοιβή Βοηθών</label>
                        <input type="text" class="form-control" id="hel" name="hel" value="{{ $cat->hel }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="ref_daily">Ημεραργία Διαιτητή</label>
                        <input type="text" class="form-control" id="ref_daily" name="ref_daily" placeholder="ηη/μμ/ΕΕΕΕ" value="{{$cat->ref_daily}}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="hel_daily">Ημεραργία Βοηθών</label>
                        <input type="text" class="form-control" id="hel_daily" name="hel_daily" placeholder="ηη/μμ/ΕΕΕΕ" value="{{$cat->hel_daily}}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="eu_Km">Χιλιομετρική Αποζημίωση Διαιτητών</label>
                        <input type="text" class="form-control" id="eu_Km" name="eu_Km" value="{{ $cat->eu_Km }}">
                       
                      </div>
                      <div class="form-group">
                        <label for="wa_ma">Αμοιβή Παρατηρητή</label>
                        <input type="text" class="form-control" id="wa_ma" name="wa_ma" value="{{ $cat->wa_ma }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="waEuKm">Χιλιομετρική Αποζημίωση Παρατηρητή</label>
                        <input type="text" class="form-control" id="waEuKm" name="waEuKm" value="{{ $cat->waEuKm }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="wa_ref">Αμοιβή Παρατηρητή Διαιτησίας</label>
                        <input type="text" class="form-control" id="wa_ref" name="wa_ref" value="{{ $cat->wa_ref }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="waRefEuKm">Χιλιομετρική Αποζημίωση Παρατηρητή Διαιτησίας</label>
                        <input type="text" class="form-control" id="waRefEuKm" name="waRefEuKm" value="{{ $cat->waRefEuKm }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="doc">Αμοιβή Υγειονομικού Προσωπικού</label>
                        <input type="text" class="form-control" id="doc" name="doc" value="{{ $cat->doc }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="docEuKm">Χιλιομετρική Αποζημίωση Υγειονομικού Προσωπικού</label>
                        <input type="text" class="form-control" id="docEuKm" name="docEuKm" value="{{ $cat->docEuKm }}">
                        
                      </div>

                      
                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    @endforeach
    
        
@endsection

@section('after-scripts')
   
    {{ Html::script("//code.jquery.com/ui/1.11.2/jquery-ui.js") }}
    
    <script>

    $(document).ready(function () {
          $( ".form-control" ).on('focusout',function(){
              var text = $(this).val();
              $(this).val(text.replace(',', '.')); 
          });
      });

    </script>
@endsection
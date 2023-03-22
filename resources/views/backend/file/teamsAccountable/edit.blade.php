@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Υπόλογοι Σωματείων</small>
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
            <h3 class="box-title">Επεξεργασία Υπόλογου Σωματείου</h3>

           <div class="box-tools pull-right">

                @include('backend.includes.partials.teamsAccountable-header-buttons')
            </div>
        </div><!-- /.box-header -->
        @foreach ($teamsAccountable as $teamsAccount)
        <div class="box-body">
            <div class="with-border">
                <form method="POST" action="{{ route('admin.file.teamsAccountable.update', $teamsAccount->id) }}">
                    {{ csrf_field() }}
                   <div class="form-group">
                        <label for="Surname">Επώνυμο*</label>
                        <input type="text" class="form-control" id="Surname" name="Surname" value="{{ $teamsAccount->Surname }}" >
                        
                      </div>
                      <div class="form-group">
                        <label for="Name">Όνομα*</label>
                        <input type="text" class="form-control" id="Name" name="Name" value="{{ $teamsAccount->Name }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="FName">Όνομα Πατέρα</label>
                        <input type="text" class="form-control" id="FName" name="FName" value="{{ $teamsAccount->FName }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Address">Διεύθυνση</label>
                        <input type="text" class="form-control" id="Address" name="Address" value="{{ $teamsAccount->Address }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Tk">ΤΚ</label>
                        <input type="text" class="form-control" id="Tk" name="Tk" value="{{ $teamsAccount->Tk }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Region">Περιοχή</label>
                        <input type="text" class="form-control" id="Region" name="Region" value="{{ $teamsAccount->Region }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="City">Πόλη</label>
                        <input type="text" class="form-control" id="City" name="City" value="{{ $teamsAccount->City }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Tel">Σταθερό Τηλέφωνο</label>
                        <input type="text" class="form-control" id="Tel" name="Tel" value="{{ $teamsAccount->Tel }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="Mobile">Κινητό Τηλέφωνο*</label>
                        <input type="text" class="form-control" id="Mobile" name="Mobile" value="{{ $teamsAccount->Mobile }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="email">e-mail*</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $teamsAccount->email }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="team">Ομάδα*</label>
                        <?php $items= App\Models\Backend\team::where('parent','=',0)->where('active','=',1)->orderBy('onoma_web')->pluck('onoma_web', 'team_id');  ?>
                        {!! Form::select('team', $items, $teamsAccount->team_id, ['class'=>'form-control']) !!}
                        
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
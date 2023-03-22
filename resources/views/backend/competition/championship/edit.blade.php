@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Πρωταθλήματα</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Επεξεργασία Ομίλου</h3>

           <div class="box-tools pull-right">

                @include('backend.competition.partials.championship-header-buttons')
            
        </div><!-- /.box-header -->
        @foreach ($groups as $group)
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => array('admin.competition.championship.update',$group->id), 'files' => true])}}
               <?php $nTeams=$group->omades; 
                      $cat= $group->category;?> 
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="omilos">Όνομα</label>
                        <input type="text" class="form-control" id="omilos" name="omilos" aria-describedby="Herbhelp" value="{{ $group->omilos }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="title">Πλήρες Όνομα</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $group->title }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="onoma_web">Λογότυπο</label>
                        @if (strlen($group->logo)>0)
                        <img src="{{ $group->logo }}" class="img-thumbnail" style="max-width: 200px; height: auto;"/>
                        @endif
                        {{Form::file('logo')}}
                      </div>
                      <div class="form-group">
                        <label for="qualify">Προβιβάζονται</label>
                        <input type="text" class="form-control" id="qualify" name="qualify" value="{{ $group->qualify }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="relegation">Υποβιβάζονται</label>
                        <input type="text" class="form-control" id="relegation" name="relegation" value="{{ $group->relegation }}">
                       
                      </div>
                      <div class="form-group">
                        <label for="q_mparaz">Μπαράζ Προβιβασμού</label>
                        <input type="text" class="form-control" id="q_mparaz" name="q_mparaz" value="{{ $group->q_mparaz }}">
                        
                      </div>
                      <div class="form-group">
                        <label for="r_mparaz">Μπαράζ Υποβιβασμού</label>
                        <input type="text" class="form-control" id="r_mparaz" name="r_mparaz" value="{{ $group->r_mparaz }}">
                        
                      </div>

            </div>  
                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    @endforeach
    
        
@endsection

@section('after-scripts')
   
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js") }}
    
    <script>
$(document).ready(function () {
  
});
    </script>
@endsection
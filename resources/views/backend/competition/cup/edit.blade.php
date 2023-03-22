@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Πρωταθλήματα</small>
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
            <h3 class="box-title">Επεξεργασία Ομίλου</h3>

           <div class="box-tools pull-right">

                @include('backend.competition.partials.cup-header-buttons')
            
        </div><!-- /.box-header -->
        @foreach ($groups as $group)
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => array('admin.competition.cup.update',$group->id), 'files' => true])}}
                
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
                      <?php $items= App\Models\Backend\phases::pluck('title', 'id'); ?>
                      <div class="form-group">
                                  <label for="iso">Φάση*</label>
                                  {!! Form::select('phases',  $items, $group->phase, ['class'=>'form-control', 'id'=>'phases', 'data-style'=>'btn-danger']) !!}
                      </div>
                      <div class="form-group">
                        <label for="qualify">Περνάνε στην επόμενη φάση</label>
                        <input type="text" class="form-control" id="qualify" name="qualify" value="{{ $group->qualify }}">
                        
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

      $(function() {
          $( "#Bdate" ).datepicker({
            format: 'd/m/Y'
          });
      });

    </script>
@endsection
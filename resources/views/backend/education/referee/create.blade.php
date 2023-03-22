@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Εκπαιδευτικό Υλικό</small>
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
            <h3 class="box-title">Εισαγωγή Νέου ΕΚπαιδευτικού Υλικού </h3>

           <div class="box-tools pull-right">

           @include('backend.education.referee.includes.header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => 'admin.education.referees.store', 'files' => true])}}
                
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="onoma_web">Τίτλος</label>
                        {!! Form::text('title', $value = '', [
                            'placeholder'   => 'Τίτλος Εκπαιδευτικού Υλικού',
                            'class'         => 'form-control',
                            ]) !!}
                        
                      </div>
                      <div class="form-group">
                        <label for="pdf">Ανέβασμα Υλικού</label>
                        {{Form::file('pdf')}}
                      </div>

                      <div class="form-group">
                        <label for="video_link">Video Σύνδεσμος</label>
                        <input type="text" class="form-control" id="video_link" name="video_link" placeholder="Video Σύνδεσμος">
                        
                      </div>
                      <div class="form-group">
                        <label for="BirthYear">Περιγραφή</label>
                        <input type="text" class="form-control" id="details" name="details" placeholder="Περιγραφή">
                        
                      </div>
                      @for($i = 1; $i<=5; $i++)
                      <div class="divider"></div>
                      <h3 class="box-title" style="margin-top: 10px">Ερώτηση {{$i}}</h3>
                      <div class="form-group">
                        <label for="BirthYear">Ερώτηση</label>
                        <input type="text" class="form-control" id="question{{$i}}" name="question[]" placeholder="Ερώτηση">
                      </div>
                      <div class="form-group">
                        <label for="BirthYear">Απάντηση</label>
                        <input type="text" class="form-control" id="answer{{$i}}" name="answer[]" placeholder="Απάντηση">
                      </div>
                      <div class="form-group">
                        <label for="BirthYear">Υπόδειξη</label>
                        <input type="text" class="form-control" id="suggestion{{$i}}" name="suggestion[]" placeholder="Υπόδειξη">
                      </div>
                      @endfor

                      <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    
    
        
@endsection

@section('after-scripts')

    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    
    <script>

      $(function() {
          
      });

    </script>
@endsection
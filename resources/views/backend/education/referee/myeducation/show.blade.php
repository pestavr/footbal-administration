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
            <h3 class="box-title">Επεξεργασία εκπαιδευτικού Υλικού </h3>

           <div class="box-tools pull-right">

           @include('backend.education.referee.myeducation.includes.header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
              {{Form::open(['method' => 'post', 'route' => ['admin.education.referees.myeducation.update', $refereeEducation->id], 'files' => false])}}
                
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <p>Τίτλος:&nbsp;{{$refereeEducation->title}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p>Σύνδεσμος:&nbsp;<a href="{{$refereeEducation->reference_link}}" target="_blank">{{$refereeEducation->reference_link}}</a></p>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-12">
                            <p>Περιγραφή:&nbsp;{{$refereeEducation->details}}</p>
                        </div>
                    </div>        
                      @if(!empty($refereeEducation->questions))
                        @foreach($refereeEducation->questions as $question)
                        <div class="divider"></div>
                        <div id="question-{{$question->id}}-container">
                          <h3 class="box-title" style="margin-top: 10px">Ερώτηση</h3>
                          <div class="row">
                            <div class="col-12">
                              <p>Ερώτηση:&nbsp;{{$question->question}}</p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <p>Υπόδειξη:&nbsp;{{$question->suggestion}}</p>
                            </div>
                          </div>
                          <div class="form-group">
                                <label for="BirthYear">Απάντηση</label>
                                <input type="text" class="form-control" name="answers[{{$question->id}}][]" placeholder="Απάντηση" value="{{ null !== $question->answers->first() ? $question->answers->first()->answer : '' }}">
                          </div>
                          @if(!empty($question->answers->first()))
                          <div class="row">
                            <div class="col-12">
                              <p>Απάντηση:&nbsp;{{$question->answer}}</p>
                            </div>
                          </div>
                          @endif
                          @if(!empty($question->answers->first()) && !empty($question->answers->first()->comment))
                          <div class="row">
                            <div class="col-12">
                              <p>Σχόλιο Από Εκπαιδευτή:&nbsp;{{$question->answers->first()->comment}}</p>
                            </div>
                          </div>
                          @endif
                          @if(!empty($question->answers->first()) && !empty($question->answers->first()->right_answer))
                          <div class="row">
                            <div class="col-12">
                              <p>Σωστή:&nbsp;{{ $question->answers->first()->right_answer == 1 ? 'Ναι' : 'Όχι' }}</p>
                            </div>
                          </div>
                          @endif
                        </div>
                        @endforeach
                      @endif
                      <button type="submit" class="btn btn-primary">Αποστολή</button>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    
@include('backend.education.referee.modals.edit-question')
@endsection

@section('after-scripts')

    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    
    <script>     

    </script>
@endsection
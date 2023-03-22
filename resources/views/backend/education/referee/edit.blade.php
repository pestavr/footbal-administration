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

           @include('backend.education.referee.includes.header-buttons')
            
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">

              {{Form::open(['method' => 'post', 'route' => ['admin.education.referees.update', $refereeEducation->id], 'files' => true])}}
                
                    {{ csrf_field() }}
                      <div class="form-group">
                        <label for="onoma_web">Τίτλος</label>
                        {!! Form::text('title', $value = $refereeEducation->title, [
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
                        <input type="text" class="form-control" id="details" name="details" placeholder="Περιγραφή" value="{{$refereeEducation->details}}">
                        
                      </div>
                      @if(!empty($refereeEducation->questions))
                        @foreach($refereeEducation->questions as $question)
                        <div class="divider"></div>
                        <div id="question-{{$question->id}}-container">
                          <h3 class="box-title" style="margin-top: 10px">Ερώτηση</h3>
                          <span class="btn btn-success edit-question" data-id="{{$question->id}}">Επεξεργασία</span>
                          <span class="btn btn-danger delete-question" data-id="{{$question->id}}">Διαγραφή</span>
                          <div class="row">
                            <div class="col-12">
                              <p>Ερώτηση:&nbsp;{{$question->question}}</p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <p>Απάντηση:&nbsp;{{$question->answer}}</p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <p>Υπόδειξη:&nbsp;{{$question->suggestion}}</p>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      @endif
                      <h3 class="box-title" style="margin-top: 10px">Προσθήκη Ερωτήσεων</h3>
                      @for($i = 1; $i<=5; $i++)
                      <div class="divider"></div>
                      <h3 class="box-title" style="margin-top: 10px">Ερώτηση {{$i}}</h3>
                      <div class="form-group">
                        <label for="BirthYear">Ερώτηση</label>
                        <input type="text" class="form-control" id="questions{{$i}}" name="questions[]" placeholder="Ερώτηση">
                      </div>
                      <div class="form-group">
                        <label for="BirthYear">Απάντηση</label>
                        <input type="text" class="form-control" id="answer{{$i}}" name="answers[]" placeholder="Απάντηση">
                      </div>
                      <div class="form-group">
                        <label for="BirthYear">Υπόδειξη</label>
                        <input type="text" class="form-control" id="suggestion{{$i}}" name="suggestions[]" placeholder="Υπόδειξη">
                      </div>
                      @endfor

                      <button type="submit" class="btn btn-primary">Ενημέρωση</button>
                    {{Form::close()}}
            </div>
    </div><!--box-->
    
@include('backend.education.referee.modals.edit-question')
@endsection

@section('after-scripts')

    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    
    <script>

      $(document).on('click', '.edit-question',  function() {
        let question = $(this).data('id');
        $.ajax( {
            url: "{{route('admin.education.referees.edit', $refereeEducation->id)}}",
            method: "get",
            data: {
              "_token": "{{ csrf_token() }}",
              question: question
            },
            success: function( data ) {
               if (data.ok){
                 $('#modal-id').val(data.question.id);
                 $('#modal-question').val(data.question.question);
                 $('#modal-answer').val(data.question.answer);
                 $('#modal-suggestion').val(data.question.suggestion);
                 $('#edit-question-modal').appendTo('body').modal('show');
               }
            },
            error: function (response) {
                    console.log(response); 
            }
          });
        
      });

      $(document).on('click', '.delete-question',  function(e) {
        let question = $(this).data('id');
        e.preventDefault();
        
        swal({
            title: "{{ trans('strings.backend.general.are_you_sure') }}",
            text: "Είστε σίγουρος ότι θέλετε να σβήσετε την ερώτηση;",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{ trans('strings.backend.general.continue') }}",
            cancelButtonText: "{{ trans('buttons.general.cancel') }}",
            closeOnConfirm: true
        }, function(isConfirmed){
            if (isConfirmed){
              $.ajax( {
                url: "{{route('admin.education.referees.delete', $refereeEducation->id)}}",
                method: "get",
                data: {
                  question : question
                 },
                success: function( data ) {
                  if (data.ok){
                    $('#question-'+question+'-container').html('');
                  }
                },
                error: function (response) {
                        console.log(response); 
                }
              });
            }
        });
        
      });

      $('#modal-save').on('click', function() {
        let question =  $('#modal-id').val();
        $.ajax( {
            url: "{{route('admin.education.referees.update', $refereeEducation->id)}}",
            method: "post",
            data: {
              "_token" : "{{ csrf_token() }}",
              id : question,
              question : $('#modal-question').val(),
              answer : $('#modal-answer').val(),
              suggestion : $('#modal-suggestion').val(),
            },
            success: function( data ) {
               if (data.ok){
                 $('#question-'+question+'-container').html(data.question);
                 $('#edit-question-modal').modal('hide');
               }
            },
            error: function (response) {
                    console.log(response); 
            }
          });
        
      });
      

    </script>
@endsection
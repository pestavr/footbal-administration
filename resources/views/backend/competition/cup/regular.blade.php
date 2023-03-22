@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Κύπελλο- Νέος Όμιλος</small>
    </h1>
@endsection

@section('after-styles')

    {{ Html::style("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css")}}
   
@endsection

@section('content')
{!! Form::open(array('url' => route("admin.competition.cup.saveGroup"))) !!}
    <div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Δημιουργία Νέου Ομίλου Κυπέλλου</h3>

            <div class="box-tools pull-right">
               @include('backend.competition.partials.championship-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                                <label for="iso">Κατηγορία</label>
                                {!! Form::text('category', 'Κύπελλο', ['class'=>'form-control', 'id'=>'category', 'data-style'=>'btn-danger', 'readonly'=>'readonly']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                <?php $items= App\Models\Backend\phases::pluck('title', 'id'); ?>
                    <div class="form-group">
                                <label for="iso">Φάση*</label>
                                {!! Form::select('phases',  $items, null, ['class'=>'form-control', 'id'=>'phases', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Φάση']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Πλήθος Ομάδων*</label>
                                {!! Form::text('nTeams', '', ['class'=>'form-control', 'id'=>'nTeams', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Όνομα Ομίλου*</label>
                                {!! Form::text('groupName', '', ['class'=>'form-control', 'id'=>'groupName', 'data-style'=>'btn-danger', 'placeholder' => 'Όνομα Ομίλου (Υποχρεωτικό)']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Περνάνε στην επόμενη Φάση</label>
                                {!! Form::text('qualify', '0', ['class'=>'form-control', 'id'=>'qualify', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                
            </div>
            <div class="row">
                    <div class="col-md-12">
                         <label for="iso">Ομάδες Ομίλου</label>
                        <CENTER><select name="teams[]" multiple="multiple" id="teamSelect" class="form-control"></select></CENTER>
                    </div>
            </div>  
           <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <CENTER><button type="submit" id="show" class="btn btn-primary">Αποθήκευση</button></CENTER>
                </div>
            </div>   
            
        </div><!-- /.box-body -->
    </div>
{!! Form::close() !!}
@endsection

@section('after-scripts')
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js") }}
    

    <script>
        $(document).ready(function () {
            var category=1;
            var nTeams=0;
            
           $("form").on("submit", function () {
                $(this).find(":submit").prop("disabled", true);
            });
            $('#nTeams').on('focusout',function(){
                nTeams=$(this).val();
                 $('#teamSelect').select2({
                               placeholder: "Επιλέξτε τις Ομάδες του Ομίλου",
                               ajax: {
                                        url: '{{ route("admin.file.team.getTeamsPerAgeLevel") }}',
                                        dataType: 'json',
                                        delay: 500,
                                        data: function (params) {
                                              var query = {
                                                search: params.term,
                                                cat: {{config('default.cup')}}
                                              }

                                              // Query parameters will be ?search=[term]&type=public
                                              return query;
                                            },
                                        processResults: function (data) {
                                                return {
                                                    results: data
                                                };
                                            },
                                         params: {
                                                error: function(response) {
                                                    alert("error fetching data"); 
                                                }
                                            },
                                            cache: true
                                      },
                                maximumSelectionLength: nTeams,
                                allowClear: true
                             });
            });
            $('#teamSelect').select2({placeholder: "Επιλέξτε τις Ομάδες του Ομίλου"});
            

        });
    </script>
@endsection
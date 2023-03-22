@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Μηνιαία Αναφορά Προς ΕΠΟ</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
    {{ Html::style(asset('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css'))}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
   
@endsection

@section('content')

<div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Μηνιαία Αναφορά Προς ΕΠΟ </h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                                <label for="iso">Μήνας και Έτος :</label>
                                {!! Form::input('text','date_from', '', array('class'=>'form-control datepicker', 'id'=>'date_from', 'data-date-format'=>'mm-yyyy', 'placeholder'=>'Μήνας- Έτος')) !!}
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-12">
                        <CENTER><button type="button" id="show" class="btn btn-primary">Εμφάνιση</button></CENTER>
                    </div>
                </div>   
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

<div class="box box-danger">
        <div class="box-header with-border">
             <h3 class="box-title">Μηνιαία Αναφορά Προς ΕΠΟ</h3>

            <div class="box-tools pull-right">
               @include('backend.program.partials.buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Ημερομηνία</th>
                        <th>Διοργάνωση</th>
                        <th>Αγωνιστική</th>
                        <th>Ώρα</th>
                        <th>Γηπεδούχος</th>
                        <th>Φιλοξενούμενη</th>
                        <th>Σκορ</th>
                        <th>Διαιτητής</th>   
                        <th>Βαθμός</th>  
                        <th>Βοηθός1</th>   
                        <th>Βαθμός</th>
                        <th>Βοηθός2</th>   
                        <th>Βαθμός</th>
                        <th>Παρατηρητής</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
</div><!--box-->

@endsection

@section('after-scripts')
   {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}
    {{ Html::script("https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js")}}
    {{ Html::script("//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js")}}
    {{ Html::script("//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js")}}
    {{ Html::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js")}}
    {{ Html::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js")}}
    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.el.js")) }}
    

    <script>
        $(document).ready(function () {
            $('#selectAll').change(function(){
                var check=$(this).is(':checked');
                $('.match').each(function(index, element){
                    $(element).prop('checked',check);
                });
            });
            $('#selectAll-publ').change(function(){
                var check=$(this).is(':checked');
                $('.publ').each(function(index, element){
                    $(element).prop('checked', check);
                });
            });

             $(document).on('change','.publ',function(){
                 /*check for the 15 days same team vuikation*/
                  var check=$(this).is(':checked');
                  var match=$(this).val();
                  var stat=(check)?0:1;
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.showEpoReport') }}",
                                  data: {
                                    match_id: match,
                                    status: stat
                                  },
                                  success: function( data ) {
                                            
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
             });


            var buttonCommon = {
                exportOptions: {
                    format: {
                        body: function ( data, row, column, node ) {
                            // Strip $ from salary column to make it numeric
                            return column === 5 ?
                                data.replace( /[$,]/g, '' ) :
                                data;
                        }
                    }
                }
            };
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
    var oTable= $('#match-table').dataTable({
                processing: false,
                serverSide: true,
                autoWidth: true,
                ajax: {
                    url: '{{ route("admin.orismos.referee.showEpoReport") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.date_from= $('#date_from').val();
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'competition', name: 'competition', sortable: false},
                    {data: 'match_day', name: 'match_day', sortable: false},
                    {data: 'time', name: 'time', sortable: false},
                    {data: 'ghp', name: 'ghp', sortable: false},
                    {data: 'fil', name: 'fil', sortable: false},
                    {data: 'score', name: 'score', sortable: false},
                    {data: 'referee', name: 'referee', sortable: false},
                    {data: 'ref_grades', name: 'ref_grades', sortable: false},
                    {data: 'helper1', name: 'helper1', sortable: false},
                    {data: 'h1_grades', name: 'h1_grades', sortable: false},
                    {data: 'helper2', name: 'helper2', sortable: false},
                    {data: 'h2_grades', name: 'h2_grades', sortable: false},
                    {data: 'ref_paratiritis', name: 'ref_paratiritis', sortable: false}
                ],
                "lengthMenu": [[  -1 ],['All']],
               
                
                searchDelay: 1500,
                dom: 'lBfrtip',
                buttons: [
                    $.extend( true, {}, buttonCommon, {
                        extend: 'copyHtml5',
                         exportOptions: {
                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]
                                        }
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'excelHtml5',
                         exportOptions: {
                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]
                                        }
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'pdfHtml5',
                         exportOptions: {
                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]
                                        }
                    } )
                ]
               
            });
    $('#show').on('click', function(e){
        oTable.fnDraw();
        e.preventDefault();
    });

        $(document).on('focus','#date_from', function(){
                            
                            $(this).datetimepicker({
                                        language:  'el',
                                        format: "mm-yyyy",
                                        startView: 4,
                                        minView: 3,
                                        autoclose: true,
                                        pickerPosition: "bottom-left",
                                        initialDate: new Date()
                                    })
                                   
                            
                            });

        });
    </script>
@endsection
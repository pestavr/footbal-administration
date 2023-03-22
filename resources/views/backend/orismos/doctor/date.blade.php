@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ορισμοί Υγειονομικού Προσωπικού</small>
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
             <h3 class="box-title">Ορισμός Υγειονομικού Προσωπικού Ανά Ημερομηνία</h3>

            <div class="box-tools pull-right">
                @include('backend.orismos.partials.header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                                <label for="iso">Ημερομηνία Από :</label>
                                {!! Form::input('text','date_from','', array('class'=>'form-control datepicker', 'id'=>'date_from', 'data-date-format'=>'mm/dd/yyyy', 'placeholder'=>'Από')) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                                <label for="iso">Ημερομηνία Έως:</label>
                                {!! Form::input('text','date_to','', array('class'=>'form-control datepicker', 'id'=>'date_to',  'placeholder'=>'Μέχρι')) !!}
                    </div>
                </div>
                <div class="col-md-4">
                   
                </div>
               <div class="row">
                    <div class="col-md-12">
                        <CENTER><button type="button" id="show" class="btn btn-primary">Εμφάνιση</button></CENTER>
                    </div>
                </div>   
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

{!! Form::open(array('url' => route("admin.program.program.saveSelected"))) !!}
<div class="box box-danger">
        <div class="box-header with-border">
             <h3 class="box-title">Πρόγραμμα</h3>

            <div class="box-tools pull-right">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                         <th>Κατηγορία</th>
                        <th>Ημ/νια-Γήπεδο</th>
                        <th>Αναμέτρηση</th>
                        <th>Υγειονομικός</th>
                        <th>Δημοσίευση
                            <center><span class="modal-trigger btn btn-xs btn-primary " id="selectAll-publ"><i class="glyphicon glyphicon-cloud-upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Δημοσίευση όλων"></i></span></center>
                        </th> 
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
</div><!--box-->
{!! Form::close() !!}

@endsection

@section('after-scripts')
   {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}
    {{ Html::script("https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js")}}
    {{ Html::script("//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js")}}
    {{ Html::script("//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js")}}
    {{ Html::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js")}}
    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.el.js")) }}
    

    <script>
        $(document).ready(function () {
$('#selectAll-publ').click(function(){
                
                $('.publ').each(function(index, element){
                  var check=$(this).is(':checked');
                  check=!check;
                   var match=$(this).val();
                  var stat=(check)?1:0;
                            $.ajax( {
                                  url: "{{ route('admin.orismos.doctor.savePubl') }}",
                                  data: {
                                    match_id: match,
                                    status: stat
                                  },
                                  success: function( data ) {
                                          $(element).prop('checked', check);  
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                });
            });

             $(document).on('change','.publ',function(){
                 /*check for the 15 days same team vuikation*/
                  var check=$(this).is(':checked');
                  var match=$(this).val();
                  var stat=(check)?1:0;
                            $.ajax( {
                                  url: "{{ route('admin.orismos.doctor.savePubl') }}",
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
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.orismos.doctor.getDate") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.date_from= $('#date_from').val();
                            d.date_to=$('#date_to').val();
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'category', name: 'category', sortable: false},
                    {data: 'date-court', name: 'date-court', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'doctor', name: 'doctor', sortable: false},
                    {data: 'doc_publ', name: 'doc_publ', sortable: false},
                ],
                columnDefs: [
                               { type: 'date-euro', targets: 1 }
                             ],
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                order: [[0, "asc"]],
                
                searchDelay: 1500, 
                "fnDrawCallback": function( ) {
                                  
                                   
                                   
                                }
               
            });

    $(document).on('focus','#date_from', function(){
                            
                            $(this).datetimepicker({
                                        language:  'el',
                                        format: "dd/mm/yyyy",
                                        autoclose: true,
                                        todayBtn: true,
                                        minView: 2,
                                        pickerPosition: "bottom-left",
                                        initialDate: new Date()
                                    })
                                   
                            
                            });
    $(document).on('focus','#date_to', function(){
                           
                            $(this).datetimepicker({
                                        language:  'el',
                                        format: "dd/mm/yyyy",
                                        autoclose: true,
                                        todayBtn: true,
                                        minView: 2,
                                        pickerPosition: "bottom-left",
                                        initialDate: new Date()
                                    })
                                   
                            
                            });

    $('#show').on('click', function(e){
        oTable.fnDraw();
        e.preventDefault();
    });
    var $cur_date_time= '';
   
 $(document).on('focus','.doctor', function(){
                $(".doctor").autocomplete({
                          source: function( request, response ) {
                                              $.ajax( {
                                                url: "{{ route('admin.file.doctor.getDoctor') }}",
                                                dataType: "json",
                                                data: {
                                                  term: request.term
                                                },
                                                success: function( data ) {
                                                  response( data );
                                                },
                                                error: function (xhr, err) {
                                                    //if (err === 'parsererror')
                                                        console.log(xhr.responseText);
                                                        exit();
                                                }
                                              } );
                                            },
                          minLength: 2,
                          select: function(event, ui) {
                            var match= $(this).attr('match');
                            var rel= $(this).attr('rel');
                            $('#doc_id-'+match).val(ui.item.id);                             
                            /* Check if doctor is at another match*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.doctor.checkOtherMatch') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match
                                  },
                                  success: function( data ) {

                                            $('#sameTime-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                            /* assigns doctor to match*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.doctor.save') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match,
                                    kind: rel
                                  },
                                  success: function( data ) {

                                            $('#save-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                          }
                      });
});
        });
    </script>
@endsection
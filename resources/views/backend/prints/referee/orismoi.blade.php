@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Οριμοί Διαιτητών</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
    {{ Html::style(asset('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css'))}}

    
@endsection

@section('content')
<div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Ορισμοί Διαιτητών Ανά Ημερομηνία</h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
            	<div class="row">
                    <div class="col-md-6">                  
                        <div class="input-group date">
                                    <label for="iso">Ημερομηνία:</label>
                                    {!! Form::input('text','date_from', '', array('class'=>'form-control datepicker', 'id'=>'date_from', 'data-date-format'=>'mm/dd/yyyy', 'placeholder'=>'Από')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="input-group date">
                                    <label for="iso">Ημερομηνία:</label>
                                    {!! Form::input('text','date_to', '', array('class'=>'form-control datepicker', 'id'=>'date_to',  'placeholder'=>'Μέχρι')) !!}
                        </div>
                    </div>
                </div>
              <div class="row">
                <div class="col-md-3">
                    <div class="form-input">
                        <label><input type="checkbox" name="men" id="men" value="0" onclick="$(this).val(this.checked ? 1 : 0)">&nbsp;Ανδρικά</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-input">
                        <label><input type="checkbox" name="kids" id="kids" value="0" onclick="$(this).val(this.checked ? 1 : 0)">&nbsp;Υποδομές</label>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-12">
                     <center><button type="button" id="show" class="btn btn-primary" style="margin-top: 10px">Εμφάνιση</button></center> 
                </div>

            </div>
                    
            
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

<div class="box box-danger">
        <div class="box-header with-border">
             <h3 class="box-title">Ορισμοί Διαιτητών</h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                     <tr>
                        <th>Κατηγορία- Αγων</th>
                        <th>Στοιχεία Αναμέτρησης</th>
                        <th>Αναμέτρηση</th>                        
                        <th>Διαιτητής</th>
                        <th>1ος Βοηθός</th>
                        <th>2ος Βοηθός</th>  
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
    {{ Html::script("//cdn.datatables.net/plug-ins/1.10.16/sorting/date-euro.js")}}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.el.js")) }}
    {{ Html::script("//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js")}}
    {{ Html::script("//cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js")}}

    

    <script>
        $(document).ready(function () {
            $('#selectAll').change(function(){
                var check=$(this).is(':checked');
                $('input').each(function(index, element){
                    $(element).attr('checked', check);
                });
            });
            
        	$(document).on('focus','.datepicker', function(){
                           
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
                ajax: {
                    url: '{{ route("admin.prints.referee.orismoi") }}',
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
                            d.men=$('#men').val();
                            d.kids=$('#kids').val();
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'category', name: 'category', sortable: false},
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'referee', name: 'referee', sortable: false},
                    {data: 'h1', name: 'h1', sortable: false},
                    {data: 'h2', name: 'h2', sortable: false},
                ],
                columnDefs: [
                               { type: 'date-euro', targets: 1 }
                             ],
                 "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, "asc"]],
                
                searchDelay: 1500,
                 dom: 'lBfrtip',
                "orderMulti": true,
                buttons: [
                    $.extend( true, {}, buttonCommon, {
                        extend: 'copyHtml5',
                         exportOptions: {
                                            columns: ':visible'
                                        }
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'excelHtml5',
                         exportOptions: {
                                            columns: ':visible'
                                        }
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'pdfHtml5',
                         exportOptions: {
                                            columns: ':visible'
                                        }
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'print',
                        title: 'Ορισμοί Διαιτητών',
                         customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '9pt' )
                            .prepend(
                                '{{ env('APP_NAME') }}-Εκτυπώθηκε στις: {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->addHours(3)->format('d/m/Y H:i') }}'+
                                '<img src="{{ asset(env('APP_MINI_LOGO')) }}" style="position:absolute; top:0; left:0;" />'
                            );
     
                        $(win.document.body).find( 'table' )
                            .addClass( 'table table-striped' )
                            .css( 'font-size', 'inherit' );
                        },
                         exportOptions: {
                                            columns: ':visible'
                                        }
                    } ),
                     $.extend( true, {}, buttonCommon, {
                        extend: 'colvis',
                         exportOptions: {
                                            columns: [ 0, 1, 2, 3, 4 ]
                                        }
                    } )
                ]
               
            });
    $('#show').on('click', function(e){
        oTable.fnDraw();
        e.preventDefault();
    });

        });
    </script>
@endsection
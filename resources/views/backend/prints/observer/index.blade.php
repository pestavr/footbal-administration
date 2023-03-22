@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Εκτυπώσεις- Παρατηρητές</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Εκτύπωση Παρατηρητές</h3>

            <div class="box-tools pull-right">

               
            
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="referees-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Ονοματεπώνυμο</th>
                        <th>Διεύθυνση</th>
                        <th>Πόλη</th>
                        <th>Τηλέφωνο</th>
                        <th>email</th>                        
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
    {{ Html::script("//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js")}}
    {{ Html::script("//cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js")}}
    

    <script>
        $(function () {
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
            $('#referees-table').DataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route("admin.prints.observer.show") }}',
                    type: 'post',
                    data: {status: 1, trashed: false},
                    error: function (xhr, err) {
                        
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'city', name: 'city'},
                    {data: 'waTel', name: 'waTel'},
                    {data: 'email', name: 'email'},
                    
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, "asc"]],
                searchDelay: 1500,
                dom: 'lBfrtip',
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


      });
    </script>
@endsection
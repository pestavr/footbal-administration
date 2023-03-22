@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Εξοδολόγια</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
    {{ Html::style("//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css") }}


    
@endsection

@section('content')
<div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Τα Προσεχή Εξοδολόγιά μου</h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->
    </div><!--box-->
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
                        <th>Αγωνιστική</th>
                        <th>Ημερομηνία και Ώρα</th>
                        <th>Γήπεδο</th>
                        <th>Κατηγορία</th>
                        <th>Αναμέτρηση</th>                        
                        <th>{{ trans('labels.general.actions') }}</th>
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
 
    

    

    <script>
        $(document).ready(function () {
        	
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
                    url: '{{ route("admin.prints.exodologia.program") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.referee= {{ Illuminate\Support\Facades\Auth::user()->id}};
                            d.time= 'after';
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                           console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'match_day', name: 'match_day', sortable: false},
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'arena', name: 'arena', sortable: false},
                    {data: 'category', name: 'category', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                columnDefs: [
                               { type: 'date-euro', targets: 1 }
                             ],
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                order: [[0, "asc"]],
                
                searchDelay: 1500,
                dom: 'lfrtip',
               
            });
    $('#show').on('click', function(e){
        oTable.fnDraw();
        e.preventDefault();
    });

        });
    </script>
@endsection
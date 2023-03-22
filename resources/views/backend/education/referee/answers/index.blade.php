@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Απαντήσεις</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Διαχείριση Εκπαίδευσης Διαιτητών</h3>

            <div class="box-tools pull-right">

                @include('backend.education.referee.includes.header-buttons')
            
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="educations-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Διαιτητής</th>
                        <th>Απάντηση</th>
                        <th>Σχόλιο</th>
                        <th>Ημερομηνία</th>
                        <th>Σωστή</th>
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
            $('#educations-table').DataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.education.referees.answers.index", $educationQuestion->id) }}',
                    type: 'get',
                    data: {status: 1, ajax: 1,  trashed: false},
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            alert(xhr.responseText);
                    }
                },
                columns: [
                    {data: 'user', name: 'user'},
                    {data: 'answer', name: 'answer'},
                    {data: 'comment', name: 'comment', searchable: false},
                    {data: 'date_answered', name: 'date_answered', searchable: false},
                    {data: 'right_answer', name: 'right_answer', searchable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, "asc"]],
                searchDelay: 15000,
                dom: 'lBfrtip',
                buttons: [
                    $.extend( true, {}, buttonCommon, {
                        extend: 'copyHtml5',
                         exportOptions: {
                                            columns: [ 0, 1, 2, 3 ]
                                        }
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'excelHtml5',
                         exportOptions: {
                                            columns: [ 0, 1, 2, 3 ]
                                        }
                    } ),
                    $.extend( true, {}, buttonCommon, {
                        extend: 'pdfHtml5',
                         exportOptions: {
                                            columns: [ 0, 1, 2, 3 ]
                                        }
                    } )
                ]
            });

            $(document).on('blur', '.add-comment', function () {
                let answer = $(this).data('id');
                let comment = $(this).val();
                let url = "{{route('admin.education.referees.answers.update', ':answer')}}"
                url = url.replace(':answer', answer);
                $.ajax( {
                    url: url,
                    method: "get",
                    data: {
                    comment : comment
                    },
                    success: function( data ) {
                    if (data.ok){
                        
                    }
                    },
                    error: function (response) {
                            console.log(response); 
                    }
                });
            });

        });   
    </script>
@endsection
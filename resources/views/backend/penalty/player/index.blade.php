@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ποινές</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
@endsection

@section('content')
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Ποινές Ποδοσφαιριστών</h3>

            <div class="box-tools pull-right">

                @include('backend.penalty.partials.player-header-buttons')
            
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="players-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Δελτίο</th>
                        <th>Ονοματεπώνυμο</th>
                        <th>Ομάδα</th>
                        <th>Αναμέτρηση</th>
                        <th>Ημερομηνία</th>
                        <th>Αγωνιστικές</th>
                        <th>Χρήματική</th>
                        <th>Υπόλοιπο</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
    <div class="box box-warbing">
        <div class="box-header with-border">
            <h3 class="box-title">Κόκκινες Ποδοσφαιριστών που δεν έχουν περαστεί Ποινές</h3>

            <div class="box-tools pull-right">

                @include('backend.penalty.partials.player-header-buttons')
            
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="red-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Δελτίο</th>
                        <th>Ονοματεπώνυμο</th>
                        <th>Ομάδα</th>
                        <th>Αναμέτρηση</th>
                        <th>Ημερομηνία Αναμέτρησης</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
<div id="player-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="termsLabel" class="modal-title">Ποινή Ποδοσφαιριστή-Λεπτομέρειες</h3>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    
        
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
            $('#players-table').DataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.penalty.player.get") }}',
                    type: 'post',
                    data: {status: 1, trashed: false},
                    error: function (xhr, err) {
                        console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'player_id', name: 'player_id'},
                    {data: 'player', name: 'player'},
                    {data: 'team_name', name: 'team_name'},
                    {data: 'match', name: 'match'},
                    {data: 'inf_date', name: 'inf_date'},
                    {data: 'match_days', name: 'match_days'},
                    {data: 'fine', name: 'fine'},
                    {data: 'remain', name: 'remain'},
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

        

        $('#red-table').DataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.penalty.player.red") }}',
                    type: 'post',
                    data: {status: 1, trashed: false},
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'player_id', name: 'player_id'},
                    {data: 'player', name: 'player'},
                    {data: 'team_name', name: 'team_name'},
                    {data: 'match', name: 'match'},
                    {data: 'match_date', name: 'match_date'},
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


        $("body").on("click", "a[name='deactivate']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "Είστε σίγουρος ότι θέλετε να απενεργοποιήσετε τον Ποδοσφαιριστή;",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('strings.backend.general.continue') }}",
                    cancelButtonText: "{{ trans('buttons.general.cancel') }}",
                    closeOnConfirm: false
                }, function(isConfirmed){
                    if (isConfirmed){
                        window.location.href = linkURL;
                    }
                });
            });
        $('#players-table').on ('click', '.modal-trigger', function(){
          id= $(this).attr('load');
          $.get(id).done(function(data){
              $('.modal-body').html(data);
              $('#player-modal').appendTo('body').modal('show');
          }
            );
      });
    });
    </script>
@endsection
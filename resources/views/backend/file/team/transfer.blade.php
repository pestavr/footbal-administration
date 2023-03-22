@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Κινήσεις</small>
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
             <h3 class="box-title">Μεταγραφή Ποδοσφαιριστή</h3>

            <div class="box-tools pull-right">
                <?php $data=['team'=>$team]; ?>
                @include('backend.includes.partials.playersPerTeam-header-buttons', $data)
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Δελτίο</label>
                                {!! Form::text('player_id', '', ['class'=>'form-control', 'id'=>'player_id', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Επώνυμο</label>
                                {!! Form::text('Surname', '', ['class'=>'form-control', 'id'=>'Surname', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Έτος Γέννησης</label>
                                {!! Form::text('bithYear', '', ['class'=>'form-control', 'id'=>'birthYear', 'data-style'=>'btn-danger']) !!}
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
             <h3 class="box-title">Ποδοσφαιριστές</h3>

            <div class="box-tools pull-right">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Δελτίο</th>
                        <th>Επώνυμο</th>
                        <th>Όνομα</th>
                        <th>Όνομα Πατέρα</th>
                        <th>'Ετος Γέννησης</th>
                        <th>Ομάδα</th>                      
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
</div><!--box-->


<div id="match-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="termsLabel" class="modal-title">Αλλαγή ομάδων αναμέτρησης</h3>
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
    {{ Html::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js")}}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js")) }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.el.js")) }}
    {{ Html::script(asset("assets/jquery-ui-1.12.1.custom/jquery-ui.min.js")) }}
    

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
                    url: '{{ route("admin.file.players.searchPlayer", $team) }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.player_id= $('#player_id').val();
                            d.Surname= $('#Surname').val();
                            d.birthYear=$('#birthYear').val();
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'player_id', name: 'player_id', sortable: true},
                    {data: 'Surname', name: 'Surname', sortable: true},
                    {data: 'Name', name: 'Name', sortable: true},
                    {data: 'F_name', name: 'F_name', sortable: true},
                    {data: 'birthYear', name: 'birthYear', sortable: true},
                    {data: 'team_name', name: 'team_name', sortable: true},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
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
        $('#show').on('click', function(e){
        oTable.fnDraw();
        e.preventDefault();
    });

        });
    </script>
@endsection
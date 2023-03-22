@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Πρόγραμμα Live Αναμετρήσεων</small>
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
             <h3 class="box-title">Πρόγραμμα Live Αναμετρήσεων Ανά κατηγορία</h3>

            <div class="box-tools pull-right">
               
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                <?php $items= App\Models\Backend\groups::join('season', 'season.season_id','=','group1.aa_period')
                                                         ->where('season.season_id','=',session('season'))
                                                         ->pluck('title', 'aa_group'); ?>
                    <div class="form-group">
                                <label for="iso">Κατηγορία</label>
                                {!! Form::select('category',  $items, session()->get('category'), ['class'=>'form-control', 'id'=>'category', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Κατηγορία']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Από Αγωνιστική</label>
                                {!! Form::text('md_from', session()->get('md_from'), ['class'=>'form-control', 'id'=>'md_from', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                                <label for="iso">Μέχρι Αγωνιστική</label>
                                {!! Form::text('md_to', session()->get('md_to'), ['class'=>'form-control', 'id'=>'md_to', 'data-style'=>'btn-danger']) !!}
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
             <h3 class="box-title">Πρόγραμμα</h3>

            <div class="box-tools pull-right">
                @include('backend.program.partials.buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Κατηγορία</th>
                        <th>Αγων.</th>
                        <th>Ημερομηνία και Ώρα</th>
                        <th>Γήπεδο</th>
                        <th>Αναμέτρηση</th>          
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
</div><!--box-->

{!! Form::close() !!}
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
                    url: '{{ route("admin.live.live.getMD") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.category= $('#category').val();
                            d.md_from= $('#md_from').val();
                            d.md_to=$('#md_to').val();
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                 {data: 'category', name: 'category', sortable: false},
                    {data: 'match_day', name: 'match_day', sortable: false},
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'arena', name: 'arena', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                columnDefs: [
                               { type: 'date-euro', targets: 1 }
                             ],
                "lengthMenu": [ 25, 50, 75, 100 ],
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
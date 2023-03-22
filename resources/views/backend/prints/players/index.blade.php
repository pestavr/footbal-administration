@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ποδοσφαιριστές-Λίστα</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
@endsection

@section('content')
 <div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Ποδοσφαιριστές Ομάδας</h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <div class="row">
                    <?php $items= App\Models\Backend\team::selectRaw('teams.team_id as id, CONCAT(teams.onoma_web, " - ", age_level.Age_Level_Title) as team')
                                                             ->join('age_level', 'age_level.id','=','teams.age_level')
                                                             ->where('teams.active','=',1)
                                                             ->orderBy('teams.onoma_web', 'asc')
                                                             ->pluck('team', 'id'); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                                    <label for="iso">Ομάδα</label>
                                    {!! Form::select('team',  $items, session()->get('team'),  ['class'=>'form-control', 'id'=>'team', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Ομάδα']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                                    <label for="iso">Έτος Γέννησης</label>
                                    {!! Form::select('operator',  ['>='=>'>=','='=>'=','<='=>'<='], '',  ['class'=>'form-control', 'id'=>'operator', 'data-style'=>'btn-danger', 'placeholder' => 'Όλα']) !!}
                                    {!! Form::text('year',  session()->get('year'),  ['class'=>'form-control', 'id'=>'year', 'data-style'=>'btn-danger', 'placeholder' => 'Έτος Γέννησης']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                                    <label for="iso">Ενεργοί</label>
                                    {!! Form::select('active',  [1=>'Ενεργοί',0=>'Μη Ενεργοί'], '',  ['class'=>'form-control', 'id'=>'active', 'data-style'=>'btn-danger', 'placeholder' => 'Όλοι']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">

                </div>
                <center><button type="button" id="show" class="btn btn-primary" style="margin-top: 10px;">Εμφάνιση</button></center>   
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
                <table id="teams-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>A/A</th>
                        <th>Όνομα</th>
                        <th>Ηλικιακή Κατηγορία</th>
                        <th>Όμιλος</th>
                        <th>Τηλέφωνο</th>
                        <th>Email</th>
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
    {{ Html::script("//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js")}}
    {{ Html::script("//cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js")}}
    

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
    var oTable= $('#teams-table').dataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.prints.players.getPlayers") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.team= $('#team').val();
                            d.operator= $('#operator').val();
                            d.year= $('#year').val();
                            d.active= $('#active').val();
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'player_id', name: 'players.player_id', sortable: true},
                    {data: 'Surname', name: 'players.Surname', sortable: true},
                    {data: 'Name', name: 'players.Name', searchable: true, sortable: true},
                    {data: 'F_name', name: 'players.F_name', searchable: true, sortable: true},
                    {data: 'birthYear', name: 'players.birthYear', searchable: true, sortable: true},
                    {data: 'onoma_web', name: 'teams.onoma_web'},
                ],
                columnDefs: [
                               { type: 'date-euro', targets: 1 }
                             ],
                 "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
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
                        title: 'Ομάδες',
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
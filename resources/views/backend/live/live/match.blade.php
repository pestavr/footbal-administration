@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Επεξεργασία Live Αναμέτρησης</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
    {{ Html::style(asset('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css'))}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
   
@endsection

@section('content')
<?php $home=App\Models\Backend\matches::getAll($id)->team1;
      $away=App\Models\Backend\matches::getAll($id)->team2;
      $homeName= App\Models\Backend\team::getAll(App\Models\Backend\matches::getAll($id)->team1)->onoma_web;
      $awayName= App\Models\Backend\team::getAll(App\Models\Backend\matches::getAll($id)->team2)->onoma_web;
      ?>


<div class="box box-success">
        <div class="box-header with-border">
             <h3 class="box-title">Επεξεργασία της Αναμέτρησης {{ $homeName }}- {{ $awayName }}</h3>

            <div class="box-tools pull-right">
               
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                {{Form::open(['method' => 'post', 'route' => array('admin.live.live.insertEvent',$id)])}}
                <?php $items= [2=>'Γκολ', 3=>'Κόκκινη Κάρτα', 4=>'Κίτρινη Κάρτα', 5=>'Τέλος Αναμέτρησης', 6=>'Αυτογκόλ']; ?>
                    <div class="form-group">
                                <label for="iso">Γεγονός</label>
                                {!! Form::select('event',  $items, '', ['class'=>'form-control', 'id'=>'event', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Γεγονός']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?php $teams=[$home=>$homeName, $away=>$awayName]; ?>
                                <label for="iso">Ομάδα</label>
                                {!! Form::select('team',  $teams, '', ['class'=>'form-control', 'id'=>'team', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Ομάδα']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="iso">Λεπτό</label>
                                {!! Form::text('min', '', ['class'=>'form-control', 'id'=>'min', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="iso">Ποδοσφαιριστής</label>
                                {!! Form::text('player', '', ['class'=>'form-control', 'id'=>'player', 'data-style'=>'btn-danger']) !!}
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-12">
                        <CENTER><button type="submit" id="show" class="btn btn-primary">Αποθήκευση</button></CENTER>
                    </div>
                    {{Form::close()}}
                </div>   
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

<div class="box box-danger">
        <div class="box-header with-border">
             <h3 class="box-title">Γεγονότα Αναμέτρησης</h3>

            <div class="box-tools pull-right">
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Γεγονός</th>
                        <th>Ομάδα</th>
                        <th>Λεπτό</th>
                        <th>Ποδοσφαιριστής</th>
                        <th>TimeStamp</th>          
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
    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    

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
                ajax: {
                    url: '{{ route("admin.live.live.getLiveMatch") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.match_id= {{$id}};
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                 {data: 'event', name: 'event', sortable: false},
                    {data: 'team_name', name: 'team_name', sortable: false},
                    {data: 'min', name: 'min', sortable: false},
                    {data: 'player', name: 'player', sortable: false},
                    {data: 'created_at', name: 'created_at', sortable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                order: [[4, "asc"]],
                
                searchDelay: 1500, 
                "fnDrawCallback": function( ) {
                                  
                                   
                                   
                                }
               
            });
   

        });
    </script>
@endsection
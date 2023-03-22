@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Πρόγραμμα</small>
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
             <h3 class="box-title">Διαχείριση Προγράμματος Ανά κατηγορία</h3>

            <div class="box-tools pull-right">
                @include('backend.program.partials.program-header-buttons')
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
{!! Form::open(array('url' => route("admin.program.program.saveSelected"))) !!}
<div class="box box-danger">
        <div class="box-header with-border">
             <h3 class="box-title">Πρόγραμμα</h3>

            <div class="box-tools">
                @include('backend.program.partials.buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th><input type="checkbox" name="selectAll" id="selectAll" value="0"  checked="checked"></th>
                        <th>Κατηγορία</th>
                        <th>Αγων.</th>
                        <th>Ημερομηνία και Ώρα</th>
                        <th>Γήπεδο</th>
                        <th>Αναμέτρηση</th>   
                        <th>Γηπ</th>
                        <th>-</th>
                        <th>Φιλ</th>
                        <th><i class="glyphicon glyphicon-cloud-upload"></i> Δημοσίευση<br/>
                            <center><input type="checkbox" name="selectAll-publ" id="selectAll-publ" value="0"  checked="checked"></center></th>  
                        <th>Live</th>                      
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
<div id="link-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="termsLabel" class="modal-title">Εισαγωγή Link αναμέτρησης</h3>
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
            $('#selectAll').change(function(){
                var check=$(this).is(':checked');
                $('.match').each(function(index, element){
                    $(element).prop('checked',check);
                });
            });
             $('#selectAll-publ').change(function(){
                var check=$(this).is(':checked');
                $('.publ').each(function(index, element){
                    $(element).prop('checked', check);
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
                    url: '{{ route("admin.program.program.getMD") }}',
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
                 {data: 'check', name: 'check', sortable: false},
                 {data: 'category', name: 'category', sortable: false},
                    {data: 'match_day', name: 'match_day', sortable: false},
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'arena', name: 'arena', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'score1', name: 'score1', sortable: false},
                    {data: 'dash', name: 'dash', sortable: false},
                    {data: 'score2', name: 'score2', sortable: false},
                    {data: 'prog_publ', name: 'prog_publ', sortable: false},
                    {data: 'live', name: 'live', sortable: false},
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
    var $cur_date_time= '';
    $(document).on('focus','.form_datetime', function(){
                            console.log($cur_date_time);
                            var dataDate=$(this).attr('data-date');
                            var inp=$(this).attr('data-link');
                            if ($('#'+inp).val().length==0) {
                                          $('#'+inp).val($cur_date_time);
                            }
                            $(this).datetimepicker({
                                        language:  'el',
                                        format: "dd/mm/yyyy hh:ii",
                                        autoclose: true,
                                        todayBtn: true,
                                        minuteStep: 15,
                                        pickerPosition: "top-right",
                                        initialDate: dataDate
                                    })
                                   .on('changeDate', function(ev){
                                        $cur_date_time= $('#'+inp).val();
                                    });
                            
                            });
    $(document).on('focus','.court', function(){
                $(".court").autocomplete({
                          source: function( request, response ) {
                                              $.ajax( {
                                                url: "{{ route('admin.file.court.getCourt') }}",
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
                            $('#court_id-'+match).val(ui.item.id);               
                          }
                      });
                });
         $("body").on("click", "a[name='delete']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "Είστε σίγουρος ότι θέλετε να να διαγράψετε τα δεδομένα του Φύλλου Αγώνα;",
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
$('#match-table').on ('click', '.modal-trigger', function(){
          id= $(this).attr('load');
          $.get(id).done(function(data){
            console.log(data);
              $('.modal-body').html(data);
              $('#match-modal').appendTo('body').modal('show');
          }
            );
      });
    $('#match-table').on ('click', '.link-modal-trigger', function(){
          id= $(this).attr('load');
          $.get(id).done(function(data){
            console.log(data);
              $('.modal-body').html(data);
              $('#link-modal').appendTo('body').modal('show');
          }
            );
      });

        });
    </script>
@endsection
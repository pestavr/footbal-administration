@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Ορισμός Διαιτητών</small>
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
             <h3 class="box-title">Ορισμός Διαιτητών Ανά κατηγορία</h3>

            <div class="box-tools pull-right">
                @include('backend.orismos.partials.header-buttons')
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
             <h3 class="box-title">Ορισμός Διαιτητών</h3>

            <div class="box-tools pull-right">
               
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="match-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
      
                        <th>Κατηγορία</th>
                        <th>Ημ/νια-Γήπεδο</th>
                        <th>Αναμέτρηση</th>
                        <th>Διαιτητής</th>
                        <th>1ος Βοηθός</th>
                        <th>2ος Βοηθός</th>   
                        <th>Δημοσίευση
                            <center><span class="modal-trigger btn btn-xs btn-primary " id="selectAll-publ"><i class="glyphicon glyphicon-cloud-upload" data-toggle="tooltip" data-placement="top" title="" data-original-title="Δημοσίευση όλων"></i></span></center>
                        </th>   
                        @if(config('settings.ref_notify'))
                        <th>Ειδοποίηση
                          <center><span class="modal-trigger btn btn-xs btn-primary " id="selectAll-nof"><i class="glyphicon glyphicon-phone" data-toggle="tooltip" data-placement="top" title="" data-original-title="Δημοσίευση όλων"></i></span>
        
                        </th> 
                        @endif
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
</div><!--box-->
{!! Form::close() !!}
@endsection

@section('after-scripts')
   {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}
    {{ Html::script("https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js")}}
    {{ Html::script("//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js")}}
    {{ Html::script("//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js")}}
    {{ Html::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js")}}
    {{ Html::script("//code.jquery.com/ui/1.12.1/jquery-ui.min.js") }}
    {{ Html::script(asset("assets/bootstrap-datetimepicker-master/bootstrap/js/bootstrap.min.js")) }}
    

    <script>
        $(document).ready(function () {
            
             $('#selectAll-publ').click(function(){
                
                $('.publ').each(function(index, element){
                  var check=$(this).is(':checked');
                  check=!check;
                   var match=$(this).val();
                  var stat=(check)?0:1;
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.savePubl') }}",
                                  data: {
                                    match_id: match,
                                    status: stat
                                  },
                                  success: function( data ) {
                                          $(element).prop('checked', check);  
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                });
            });

             $('#selectAll-nof').click(function(){

                $('.nof').each(function(index, element){
                     var match=$(this).val();
                     var check = $(this).is(':checked');
                     if (! check){
                        var t = setTimeout(function() { 
                            $.ajax( {
                                url: "{{ route('admin.orismos.referee.saveNof') }}",
                                data: {
                                match_id: match,
                                status: 0
                                },
                                success: function( data ) {
                                $(element).prop('checked', true);  
                                $(element).prop('disabled', true);
                                $(element).next().text('Οι διαιτητές έχουν ενημερωθεί με email');
                                },
                                error: function (xhr, err) {
                                    //if (err === 'parsererror')
                                        console.log(xhr.responseText);
                                        exit();
                                }
                            });
                            console.log(match+' proccessed') 
                            }, 5000 * index);   
                     }
                      
                });
            });
             $(document).on('change','.publ',function(){
                 /*check for the 15 days same team vuikation*/
                  var check=$(this).is(':checked');
                  var match=$(this).val();
                  var stat=(check)?0:1;
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.savePubl') }}",
                                  data: {
                                    match_id: match,
                                    status: stat
                                  },
                                  success: function( data ) {
                                            
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
             });

             $(document).on('change','.nof',function(){
                 /*check for the 15 days same team vuikation*/
                  var check=$(this).is(':checked');
                  var match=$(this).val();
                  var stat=(check)?0:1;
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.saveNof') }}",
                                  data: {
                                    match_id: match,
                                    status: stat
                                  },
                                  success: function( data ) {
                                    $(this).prop('checked', check);  
                                    $(this).prop('disabled', true);
                                    $(this).next().text('Οι διαιτητές έχουν ενημερωθεί με email');   
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
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
                    url: '{{ route("admin.orismos.referee.getMD") }}',
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
                    {data: 'date-court', name: 'date-court', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'referee', name: 'referee', sortable: false},
                    {data: 'helper1', name: 'helper1', sortable: false},
                    {data: 'helper2', name: 'helper2', sortable: false},
                    {data: 'ref_publ', name: 'ref_publ', sortable: false},
                    @if(config('settings.ref_notify'))
                    {data: 'ref_nof', name: 'ref_nof', sortable: false},
                    @endif
                ],
                columnDefs: [
                               { type: 'date-euro', targets: 1 }
                             ],
                "lengthMenu": [ 10, 25, 50, 75, -1 ],
               
                
                searchDelay: 1500, 
                "fnDrawCallback": function( ) {
                                  
                                   
                                   
                                }
               
            });
    $('#show').on('click', function(e){
        oTable.fnDraw();
        e.preventDefault();
    });

    $(document).on('focus','.referee', function(){
              $(this).val('');
                $(".referee").autocomplete({
                          source: function( request, response ) {
                                              $.ajax( {
                                                url: "{{ route('admin.file.referees.getReferee') }}",
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
                            var rel= $(this).attr('rel');
                            $('#ref_id-'+match).val(ui.item.id);  
                        /*check for the 15 days same team vuikation*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.checkDays') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match
                                  },
                                  success: function( data ) {
                                            $('#ref_days-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                            /*check if referee can be at match*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.checkRefBlock') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match
                                  },
                                  success: function( data ) {

                                            $('#refBlock-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                            /*check if referee can play the two teams*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.checkTeamBlock') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match
                                  },
                                  success: function( data ) {

                                            $('#teamBlock-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                            /* Check if referee is at another match*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.checkOtherMatch') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match
                                  },
                                  success: function( data ) {

                                            $('#sameTime-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                            /* assigns referee to match*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.save') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match,
                                    kind: rel
                                  },
                                  success: function( data ) {
                                            $('input[name="notified-'+match+'"]').prop('disabled', false);
                                            $('input[name="notified-'+match+'"]').prop('checked', false);
                                            $('#save-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });

                            /* matches played with each team*/
                            $.ajax( {
                                  url: "{{ route('admin.orismos.referee.team1') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match,
                                    kind: rel
                                  },
                                  success: function( data ) {

                                            $('#team1-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });
                             $.ajax( {
                                  url: "{{ route('admin.orismos.referee.team2') }}",
                                  data: {
                                    id: ui.item.id,
                                    match_id: match,
                                    kind: rel
                                  },
                                  success: function( data ) {

                                            $('#team2-'+match+'-'+rel).html(data);
                                  },
                                  error: function (xhr, err) {
                                      //if (err === 'parsererror')
                                          console.log(xhr.responseText);
                                          exit();
                                  }
                                });

                          }
                      });
});

        });
    </script>
@endsection
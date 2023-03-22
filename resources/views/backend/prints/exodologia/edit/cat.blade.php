@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Επεξεργασία Εξοδολογίων </small>
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
             <h3 class="box-title">Εξοδολόγια Ανά Ημερομηνία</h3>

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <div class="row">
                <?php $items= App\Models\Backend\groups::join('season', 'season.season_id','=','group1.aa_period')
                                                         ->where('season.season_id','=',session('season'))
                                                         ->pluck('title', 'aa_group'); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                                    <label for="iso">Κατηγορία</label>
                                    {!! Form::select('category',  $items, session()->get('category'), ['class'=>'form-control', 'id'=>'category', 'data-style'=>'btn-danger', 'placeholder' => 'Επιλέξτε Κατηγορία']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            
                                    <label for="iso">Αγωνιστικές</label>
                                    {!! Form::text('md_from', session()->get('md_from'), ['class'=>'form-control', 'id'=>'md_from', 'data-style'=>'btn-danger']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                                    <label for="iso">Αγωνιστικές</label>
                                    {!! Form::text('md_to', session()->get('md_to'), ['class'=>'form-control', 'id'=>'md_to', 'data-style'=>'btn-danger']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <center><button type="button" id="show" class="btn btn-primary" style="margin-top:10px;">Εμφάνιση</button></center>   
                </div>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
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
                        <th>Αναμέτρηση</th>  
                        <th>Διαιτητής</th>  
                        <th>Βοηθοί</th>
                        <th>Διόδια</th>
                        <th>Παρατηρητής Διαιτησίας</th>
                        <th>Εκτυπώσιμο</th>
                        <th>Εκτυπώθηκε από Διαιτητή</th>
                        <th>{{ trans('labels.general.actions') }}</th>                      
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
</div><!--box-->

@endsection

@section('after-scripts')
    {{ Html::script("https://code.jquery.com/ui/1.12.1/jquery-ui.js")}}
   {{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}
    {{ Html::script("https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js")}}
    {{ Html::script("//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js")}}
    {{ Html::script("//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js")}}
    {{ Html::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js")}}
    {{ Html::script("//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js")}}
 
    

    

    <script>
        $(document).ready(function () {

            $('#selectAll').change(function(){
                var check=$(this).is(':checked');
                $('input').each(function(index, element){
                    $(element).attr('checked', check);
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
                    url: '{{ route("admin.prints.exodologia.get_per_md") }}',
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
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'referee', name: 'referee', sortable: false},
                    {data: 'helpers', name: 'helpers', sortable: false},
                    {data: 'tolls', name: 'tolls', sortable: false},
                    {data: 'ref_par', name: 'ref_par', sortable: false},
                    {data: 'printable', name: 'printable', sortable: false},
                    {data: 'ref_printed', name: 'ref_printed', sortable: false},
                    {data: 'actions', name: 'actions', sortable: false}
                ],
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                order: [[0, "asc"]],
                
                searchDelay: 1500,
                dom: 'lfrtip'
               
            });
    $('#show').on('click', function(e){
        oTable.fnDraw();
        e.preventDefault();
    });
    $("body").on("click", "a[name='delete']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "Είστε σίγουρος ότι θέλετε να διαγράψετε το Εξοδολόγιο;",
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
        });
    </script>
@endsection
@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Διαιτητές</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}
    {{ Html::style("https:////code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css")}}
   <style>
   @media print {
      .btn {
        display: none;
      }
      }
 </style>
@endsection

@section('content')

<div class="printable">
        <div class="box box-success">
        <div class="box-header with-border">
          @foreach ($referees as $referee)  
            <h3 class="box-title">Στατιστικά Διαιτητή {{$referee->Lastname}} {{$referee->Firstname}}</h3>
          @endforeach 
             <div class="box-tools pull-right">
                <button class="btn btn-primary btn-xs" id="print"> Εκτύπωση</button>
            </div>
        </div><!-- /.box-header -->
        
        <div class="box-body">
            <div class="with-border">
                <div class="row">
                  <div class="col-md-4">
                       <div class="box box-primary">
                        <div class="box-header with-border">
                          <h4 class="box-title">Αναμετρήσεις ως Διαιτητής</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive">
                              @foreach ($matchesRef as $ref)
                              <tr>
                                <td>
                                  {{$ref->title}}
                                </td>
                                <td>
                                  {{$ref->syn_matches}}
                                </td>
                              </tr>
                              @endforeach 
                            </table>
                        </div>
                       </div>
                  </div>
                  <div class="col-md-4">
                       <div class="box box-warning">
                        <div class="box-header with-border">
                          <h4 class="box-title">Αναμετρήσεις ως Πρώτος Βοηθός</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive">
                              @foreach ($matchesH1 as $h1)
                              <tr>
                                <td>
                                  {{$h1->title}}
                                </td>
                                <td>
                                  {{$h1->syn_matches}}
                                </td>
                              </tr>
                              @endforeach 
                            </table>
                        </div>
                       </div>
                  </div>
                  <div class="col-md-4">
                       <div class="box box-danger">
                        <div class="box-header with-border">
                          <h4 class="box-title">Αναμετρήσεις ως Δεύτερος Βοηθός</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive">
                              @foreach ($matchesH2 as $h2)
                              <tr>
                                <td>
                                  {{$h2->title}}
                                </td>
                                <td>
                                  {{$h2->syn_matches}}
                                </td>
                              </tr>
                              @endforeach 
                            </table>
                        </div>
                       </div>
                  </div>
               </div>
            </div>
    </div><!--box-->
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Πρόγραμμα</strong></h3>

             <div class="box-tools pull-right"></div>
            
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="referees-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Κωδ Αναμ</th>
                        <th>Ημερομηνία και Ώρα</th>
                        <th>Γήπεδο</th>
                        <th>Κατηγορία</th>
                        <th>Αναμέτρηση</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
</div><!--printable-->
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
    {{ Html::script(asset("assets/printThis/printThis.js")) }}
    

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
            $('#referees-table').dataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                "paging": false,
                searching: false,
                ajax: {
                    url: '{{ route("admin.matches.get", $referee->id) }}',
                    type: 'post',
                    data: {status: 1, trashed: false},
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            alert(xhr.responseText);
                    }
                },
                columns: [
                    {data: 'id', name: 'id', sortable: false},
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'arena', name: 'arena', sortable: false},
                    {data: 'category', name: 'category', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'ref', name: 'ref', sortable: false}
                ],
                order: [[1, "desc"]],
                
                searchDelay: 1500,
                
            });

        });
         $("body").on("click", "#print", function(e) {
                $(".printable").printThis({  
                  importCSS: true,            // import page CSS
                  importStyle: true,
                  pageTitle: "Στατιστικά Διαιτητή",              // add title to print page
                });
              });
         
        $("body").on("click", "a[name='deactivate']", function(e) {
                e.preventDefault();
                var linkURL = $(this).attr("href");

                swal({
                    title: "{{ trans('strings.backend.general.are_you_sure') }}",
                    text: "Είστε σίγουρος ότι θέλετε να απενεργοποιήσετε τον διαιτητή;",
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
            })
    </script>
@endsection
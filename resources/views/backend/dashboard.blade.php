@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>{{ trans('strings.backend.dashboard.title') }}</small>
    </h1>
@endsection

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
    {{ Html::style("https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css")}}

@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('strings.backend.dashboard.welcome') }} {{ $logged_in_user->name }}!</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            @roles(['Admin', 'program-manager'])
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h4>Εφαρμογή Διαχείρισης {{ App\Models\Backend\eps::getAll()->short_name}}</h4>
                            <strong>Τρέχουσα Αγωνιστική Περίοδος: {{App\Models\Backend\season::getName()->period}}</strong>
                        </div>
                        <div class="box-body">
                            
                            <p style="text-align: justify">
                            Καλώς ήλθατε στην πλατφόρμα διαχείρισης Πρωταθλημάτων Ποδοσφαίρου της {{ App\Models\Backend\eps::getAll()->short_name }}. </p> 
                    <p style="text-justify">Στην πλατφόρμα αυτή μπορείτε να διαχειριστείτε:
                    <ul>
                        <li>τις Κατηγορίες</li>
                        <li>τα Πρωταθλήματα</li>
                        <li>το Κύπελλο</li>
                        <li>τους Διαιτητές</li>
                        <li>τα Σωματεία</li>
                        <li>τους Ποδοσφαιριστές</li>
                        <li>τις Ποινές</li>
                        <li>τους Ορισμούς Διαιτητών και Λοιπού Προσωπικού</li>
                        <li>τα Φύλλα Αγώνα</li>
                        <li>τα Εξοδολόγια</li>
                        <li>τις Εκτυπώσεις</li>
                    </ul>
                    και πολλά ακόμα...
                    </p>
                    <p style="text-right">- Από την Διοίκηση της {{ App\Models\Backend\eps::getAll()->acronym}}</p>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h4>{{ App\Models\Backend\eps::getAll()->name}}</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-stripped">
                                <tr>
                                    <th>Λογότυπο</th>
                                    <td><img src="{{ App\Models\Backend\eps::getAll()->logo}}" class="responsive"</td>
                                </tr>
                                <tr>
                                    <th>Πλήρες Όνομα</th>
                                    <td>{{ App\Models\Backend\eps::getAll()->name}}</td>
                                </tr>
                                <tr>
                                    <th>Όνομα</th>
                                    <td>{{ App\Models\Backend\eps::getAll()->short_name}}</td>
                                </tr>
                                <tr>
                                    <th>Ακρωνύμιο</th>
                                    <td>{{ App\Models\Backend\eps::getAll()->acronym}}</td>
                                </tr>
                                <tr>
                                    <th>Έτος Ίδρυσης</th>
                                    <td>{{ App\Models\Backend\eps::getAll()->etos_idrisis}}</td>
                                </tr>
                                <tr>
                                    <th>Διεύθυνση</th>
                                    <td>{{ App\Models\Backend\eps::getAll()->address}}, {{ App\Models\Backend\eps::getAll()->tk}}, {{ App\Models\Backend\eps::getAll()->district}}, {{ App\Models\Backend\eps::getAll()->city}}, N. {{ App\Models\Backend\eps::getAll()->county}}, {{ App\Models\Backend\eps::getAll()->region}}</td>
                                </tr>
                                <tr>
                                    <th>Τηλέφωνο</th>
                                    <td> {{ App\Models\Backend\eps::getAll()->tel}}</td>
                                </tr>
                                <tr>
                                    <th>Εναλλακτικό Τηλέφωνο</th>
                                    <td> {{ App\Models\Backend\eps::getAll()->tel2}}</td>
                                </tr>
                                <tr>
                                    <th>fax</th>
                                    <td> {{ App\Models\Backend\eps::getAll()->fax}}</td>
                                </tr>
                                <tr>
                                    <th>e-mail</th>
                                    <td> {{ App\Models\Backend\eps::getAll()->email}}</td>
                                </tr>
                                <tr>
                                    <th>Site</th>
                                    <td> {{ App\Models\Backend\eps::getAll()->site_address}}</td>
                                </tr>
                                <tr>
                                    <th>Facebook</th>
                                    <td> {{ App\Models\Backend\eps::getAll()->facebook}}</td>
                                </tr>
                                <tr>
                                    <th>Twitter</th>
                                    <td> {{ App\Models\Backend\eps::getAll()->twitter}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        {{ link_to_route('admin.edit', 'Επεξεργασία', App\Models\Backend\eps::getAll()->eps_id), ['class'=>'btn btn-primary'] }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
             @needsroles('chief_referee')
             <div class="row">
                <div class="col-md-6">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h4>Εφαρμογή Διαχείρισης {{ App\Models\Backend\eps::getAll()->short_name}}</h4>
                            <strong>Τρέχουσα Αγωνιστική Περίοδος: {{App\Models\Backend\season::getName()->period}}</strong>
                        </div>
                        <div class="box-body">
                            
                            <p style="text-align: justify">
                            Καλώς ήλθατε στην πλατφόρμα διαχείρισης Πρωταθλημάτων Ποδοσφαίρου της {{ App\Models\Backend\eps::getAll()->short_name }}. </p> 
                    <p style="text-justify">Στην πλατφόρμα αυτή μπορείτε να διαχειριστείτε:
                    <ul>
                        <li>τους Ορισμούς Διαιτητών και Λοιπού Προσωπικού</li>
                        <li>τα Φύλλα Αγώνα</li>
                        <li>να εισάγετε τις Βαθμολογίες των Διαιτητών</li>
                        <li>τα Εξοδολόγια</li>
                        <li>τις Εκτυπώσεις</li>
                    </ul>
                    
                    </p>
                    <p style="text-right">- Από την Διοίκηση της {{ App\Models\Backend\eps::getAll()->acronym}}</p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            @needsroles('Admin')
            
            @endauth
            @needsroles('referee')
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h4>Προσεχείς Αναμετρήσεις που έχετε ορισθεί </h4>
                        </div>
                        <div class="box-body">
                        <div class="table-responsive">
                            <table id="next-matches-table" class="table table-condensed table-hover">
                                <thead>
                                <tr>
                                    <th>Αγωνιστική</th>
                                    <th>Ημερομηνία και Ώρα</th>
                                    <th>Γήπεδο</th>
                                    <th>Κατηγορία</th>
                                    <th>Αναμέτρηση</th>                        
                                    <th>{{ trans('labels.general.actions') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div><!--table-responsive-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h4>Εφαρμογή Διαχείρισης {{ App\Models\Backend\eps::getAll()->short_name}}</h4>
                            <strong>Τρέχουσα Αγωνιστική Περίοδος: {{App\Models\Backend\season::getName()->period}}</strong>
                        </div>
                        <div class="box-body">
                            
                            <p style="text-align: justify">
                            Καλώς ήλθατε στην πλατφόρμα διαχείρισης Πρωταθλημάτων Ποδοσφαίρου της {{ App\Models\Backend\eps::getAll()->short_name }}. </p> 
                    <p style="text-justify">Στην πλατφόρμα αυτή μπορείτε να εκτυπώσετε:
                    <ul>
                        <li>τα Φύλλα Αγώνα</li>
                        <li>τα Εξοδολόγια</li>
                    </ul>
                    
                    </p>
                     <p style="text-justify">Επίσης μπορείτε να:
                    <ul>
                        <li>εισάγετε το αποτέλεσμα της αναμέτρησης που έχετε ορισθεί μετά το τέλος της αναμέτρησης</li>
                        <li>Να δείτε τις βαθμολογίες που έχετε πάρει από τους παρατηρητές βαθμολογίας</li>
                    </ul>
                    
                    </p>
                    <p style="text-right">- Από την Διοίκηση της {{ App\Models\Backend\eps::getAll()->acronym}}</p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            @needsroles('Observer')
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h4>Εφαρμογή Διαχείρισης {{ App\Models\Backend\eps::getAll()->short_name}}</h4>
                            <strong>Τρέχουσα Αγωνιστική Περίοδος: {{App\Models\Backend\season::getName()->period}}</strong>
                        </div>
                        <div class="box-body">
                            
                            <p style="text-align: justify">
                            Καλώς ήλθατε στην πλατφόρμα διαχείρισης Πρωταθλημάτων Ποδοσφαίρου της {{ App\Models\Backend\eps::getAll()->short_name }}. </p> 
                            <p style="text-justify">Στην πλατφόρμα αυτή μπορείτε να μεταδόσετε live τις αναμετρήσεις που έχετε ορισθεί.           
                            </p>
                    
                            <p style="text-right">- Από την Διοίκηση της {{ App\Models\Backend\eps::getAll()->acronym}}</p>
                            </p>
                        </div>
                    </div>
                </div>
                    <div class="col-md-6">
                         <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Αναμετρήσεις που είστε ορισμένος</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div><!-- /.box tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                <table id="observer-match-table" class="table table-condensed table-hover">
                                    <thead>
                                    <tr>
                                        <th>Ώρα-Ημερομηνία</th>  
                                        <th>Κατηγορία</th>  
                                        <th>Αναμέτρηση</th>
                                        <th>{{ trans('labels.general.actions') }}</th>                      
                                    </tr>
                                    </thead>
                                </table>
                            </div><!--table-responsive-->
                            </div><!-- /.box-body -->
                        </div><!--box box-success-->
                    </div>
            </div>
            @endauth
        </div><!-- /.box-body -->
    </div><!--box box-success-->
@roles(['Admin','program-manager'])
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Nέα-Ενημερώσεις</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                9-1-2019: Από σήμερα λειτουργούν όλες οι εκτυπώσεις!
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    </div>
    <div class="col-md-6">
         <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Αναμετρήσεις Χωρίς Αποτέλεσμα</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="match-table" class="table table-condensed table-hover">
                        <thead>
                        <tr>
                            <th>Ώρα-Ημερομηνία</th>  
                            <th>Κατηγορία</th>  
                            <th>Αναμέτρηση</th>
                            <th>{{ trans('labels.general.actions') }}</th>                      
                        </tr>
                        </thead>
                    </table>
                </div><!--table-responsive-->
            </div><!-- /.box-body -->
        </div><!--box box-success-->
    </div>
</div>
<div id="match-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="termsLabel" class="modal-title">Καταχώρηση Σκορ</h3>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    

@endauth
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
                    url: '{{ route("admin.program.program.matchesWithOutScore") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                           console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'date_time', name: 'date_time', sortable: false},
                    {data: 'category', name: 'category', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'actions', name: 'actions', sortable: false}
                ],
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                order: [[0, "asc"]],
                
                searchDelay: 1500,
                dom: 'lfrtip'
               
            });
        var observerTable= $('#observer-match-table').dataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route("admin.program.program.getMyObserverMatches") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.observer= {{ Illuminate\Support\Facades\Auth::user()->id}};
                            d.time= 'after';
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                           console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'category', name: 'category', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'actions', name: 'actions', sortable: false}
                ],
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                order: [[0, "asc"]],
                
                searchDelay: 1500,
                dom: 'lfrtip'
               
            });
     $('#match-table').on('click', '.modal-trigger', function(){
          id= $(this).attr('load');
          $.get(id).done(function(data){
              $('.modal-body').html(data);
              $('#match-modal').appendTo('body').modal('show');
          }
            );
      });

      @needsroles('referee')
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
    var nets_matches_table= $('#next-matches-table').dataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                stateSave: true,
                ajax: {
                    url: '{{ route("admin.program.program.getMyMatches") }}',
                    type: 'post',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();
                        
                        if (token) {
                              return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: function(d){
                            d.referee= {{ Illuminate\Support\Facades\Auth::user()->id}};
                            d.time= 'before';
                             },
                    error: function (xhr, err) {
                        //if (err === 'parsererror')
                            console.log(xhr.responseText);
                            exit();
                    }
                },
                columns: [
                    {data: 'match_day', name: 'match_day', sortable: false},
                    {data: 'date', name: 'date', sortable: false},
                    {data: 'arena', name: 'arena', sortable: false},
                    {data: 'category', name: 'category', sortable: false},
                    {data: 'match', name: 'match', sortable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                columnDefs: [
                               { type: 'date-euro', targets: 1 }
                             ],
                "lengthMenu": [ 10, 25, 50, 75, 100 ],
                order: [[0, "asc"]],
                
                searchDelay: 1500,
                dom: 'lfrtip'
               
            });
    $('#show').on('click', function(e){
        nets_matches_table.fnDraw();
        e.preventDefault();
    });
     $('#match-table').on('click', '.modal-trigger', function(){
      id= $(this).attr('load');
      $.get(id).done(function(data){
          $('.modal-body').html(data);
          $('#match-modal').appendTo('body').modal('show');
      });
      });
    $('#match-table').on('click', '.grades-modal-trigger', function(){
      id= $(this).attr('load');
      $.get(id).done(function(data){
          $('.modal-body').html(data);
          $('#grades-modal').appendTo('body').modal('show');
      });
      });
      @endauth
 });
</script>
@endsection
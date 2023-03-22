@extends('frontend.layouts.app')

@section('content')
    <div class="row">

     

        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-home"></i> {{ trans('navs.general.home') }}
                </div>

                <div class="panel-body">
                    Καλώς ήλθατε στην εφαρμογή Διαχείρισης της {{ \App\Models\Backend\eps::getAll()->name }}
                    @if(config('settings.referee'))
                    <p>Η εφαρμογή αυτή μπορεί να χρησιμοποιηθεί από τους Διαιτητές της {{ \App\Models\Backend\eps::getAll()->short_name }} για να κατεβάζουν τα φύλλα αγώνα τους να τα εκτυπώνουν και να βλέπουν το πρόγραμμά τους. </p>
                    @endif
                    @if(config('settings.observer'))
                    <p>Η εφαρμογή αυτή μπορεί να χρησιμοποιηθεί από τους Παρατηρητές της {{ \App\Models\Backend\eps::getAll()->short_name }} για να συνδέονται στο σύστημα και να καταχωρούν το αποτέλεσμα της Αναμέτρησης που έχουν ορισθεί. </p>
                    @endif
                    @if(config('settings.teamManager'))
                    <p>Η εφαρμογή αυτή μπορεί να χρησιμοποιηθεί από τους Υπόλογους κάθε ομάδας της {{ \App\Models\Backend\eps::getAll()->short_name }} για να ενημερώνονται με έγγγραφα και αιτήσεις και για την καλύτερη επικοινωνία με την {{ \App\Models\Backend\eps::getAll()->short_name }}. </p>
                    @endif
                </div>
            </div><!-- panel -->

        </div><!-- col-md-10 -->
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cogs"></i> Οδηγίες
                </div>

                <div class="panel-body">
                    <p>Πατήστε στον σύνδεσμο Εγγραφή για να εγγραφείτε στην εφαρμογή. Θα πρέπει να δηλώσετε το email σας και το κινητό σας τηλέφωνο που έχετε δηλώσει στην {{ \App\Models\Backend\eps::getAll()->short_name }}. </p>
                    <!--<center><img class="image-responsive" src="{{ asset('img/frontend/register.png') }}"/></center>-->
                    <p>Όταν επιβεβαιωθεί ο λογαριασμός σας θα σας αποσταλλεί σχετικό email</p>
                    <p>Αν έχετε κάνει ήδη εγγραφή τότε θα πρέπει να πατήσετε στον σύνδεσμο σύνδεση προκειμένου να συνδεθείτε με τα στοιχεία που έσετε δηλώσει</p>
                    <!--<center><img class="image-responsive" src="{{ asset('img/frontend/login.png') }}"/></center>-->
                </div>
            </div><!-- panel -->

        </div><!-- col-md-10 -->

       
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-envelope-o"></i> {{ \App\Models\Backend\eps::getAll()->name }} </div>

                <div class="panel-body">
                    <div class="list-group">
                      <a href="{{ \App\Models\Backend\eps::getAll()->site_address }}" class="list-group-item"><i class="fa fa-home"></i> {{ \App\Models\Backend\eps::getAll()->name }} 
                        
                      </a>

                      <a href="{{ \App\Models\Backend\eps::getAll()->facebook }}" class="list-group-item" target="_blank"><i class="fa fa-facebook"></i>&nbsp;facebook</a>
                    </div>
                    <h5>Στοιχεία Επικοινωνίας</h5><br/>
                        Διεύθυνση: {{ \App\Models\Backend\eps::getAll()->address }} Τ.Κ. {{ \App\Models\Backend\eps::getAll()->tk }}. {{ \App\Models\Backend\eps::getAll()->city }}, {{ \App\Models\Backend\eps::getAll()->county }}, {{ \App\Models\Backend\eps::getAll()->region }} <br/>
                          
                        Τηλέφωνο    {{ \App\Models\Backend\eps::getAll()->tel }} και {{ \App\Models\Backend\eps::getAll()->tel2 }}<br/>
                        email   {{ \App\Models\Backend\eps::getAll()->email }}
                    
                    
                </div>
            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!--row-->
@endsection
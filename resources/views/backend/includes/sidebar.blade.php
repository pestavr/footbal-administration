<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ access()->user()->picture }}" class="img-circle" alt="User Image" />
            </div><!--pull-left-->
            <div class="pull-left info">
                <p>{{ access()->user()->full_name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('strings.backend.general.status.online') }}</a>
            </div><!--pull-left-->
        </div><!--user-panel-->

        <!-- search form (Optional) -->
        {{ Form::open(['route' => 'admin.search.index', 'method' => 'get', 'class' => 'sidebar-form']) }}
        <div class="input-group">
            {{ Form::text('q', Request::get('q'), ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('strings.backend.general.search_placeholder')]) }}

            <span class="input-group-btn">
                    <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span><!--input-group-btn-->
        </div><!--input-group-->
    {{ Form::close() }}
    <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>

            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>
            @permissions([7])
            <li class="{{ active_class(Active::checkUriPattern('admin/file/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span>Αρχείο</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/file/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/file/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/team/*')) }}">
                        <a href="{{ route('admin.file.team.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Σωματεία</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/teamsAccountable/*')) }}">
                        <a href="{{ route('admin.file.teamsAccountable.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Υπόλογοι Σωματείων</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/players/*')) }}">
                        <a href="{{ route('admin.file.players.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Ποδοσφαιριστές</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/court/*')) }}">
                        <a href="{{ route('admin.file.court.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Γήπεδα</span>
                        </a>
                    </li>
                     <li class="{{ active_class(Active::checkUriPattern('admin/file/referees/*')) }}">
                        <a href="{{ route('admin.file.referees.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Διαιτητές</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/ref_observer/*')) }}">
                        <a href="{{ route('admin.file.ref_observer.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Παρατηρητές Διαιτησίας</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/observer/*')) }}">
                        <a href="{{ route('admin.file.observer.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Παρατηρητές</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/doctor/*')) }}">
                        <a href="{{ route('admin.file.doctor.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Υγειονομικό Προσωπικό</span>
                        </a>
                    </li>
                </ul>
            </li>
             <li class="{{ active_class(Active::checkUriPattern('admin/fylla/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-exchange"></i>
                    <span>Κινήσεις</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/move/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/move/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/move/transfer/*')) }}">
                        <a href="{{ route('admin.move.transfer.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Μεταγραφές</span>
                        </a>
                    </li>
                </ul>

            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/competition/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-trophy"></i>
                    <span>Διοργανώσεις</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/competition/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/competition/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/competition/championship/*')) }}">
                        <a href="{{ route('admin.competition.championship.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Πρωτάθλημα</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/competition/cup/*')) }}">
                        <a href="{{ route('admin.competition.cup.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Κύπελλο</span>
                        </a>
                    </li>
                     <li class="{{ active_class(Active::checkUriPattern('admin/competition/category/*')) }}">
                        <a href="{{ route('admin.competition.category.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Διαχείριση Κατηγοριών</span>
                        </a>
                    </li>
                </ul>
                
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/program/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span>Πρόγραμμα</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/program/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/program/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/program/program/index')) }}">
                        <a href="{{ route('admin.program.program.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Ανά Αγωνιστική</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/program/program/date')) }}">
                        <a href="{{ route('admin.program.program.date') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Ανά Ημερομηνία</span>
                        </a>
                    </li>
                </ul>
                
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/fylla/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-address-book"></i>
                    <span>Ορισμοί</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/orismos/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/orismos/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referee/*')) }}" treeview>
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Διαιτητών</span>
                        </a>
                         <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/orismos/referee/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/orismos/referee/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referee/date')) }}">
                                <a href="{{ route('admin.orismos.referee.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referee/index')) }}">
                                <a href="{{ route('admin.orismos.referee.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    @if(config('settings.refObserver-Orismos'))
                   <li class="{{ active_class(Active::checkUriPattern('admin/orismos/refObserver/*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Παρατηρητών Διαιτησίας</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/orismos/refObserver/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/orismos/refObserver/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/refObserver/date')) }}">
                                <a href="{{ route('admin.orismos.refObserver.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/refObserver/index')) }}">
                                <a href="{{ route('admin.orismos.refObserver.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                        
                    </li>
                    @endif
                    @if(config('settings.Doctor-Orismos'))
                     <li class="{{ active_class(Active::checkUriPattern('admin/orismos/doctor/*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Υγειονομικού Προσωπικό</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/orismos/doctor/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/orismos/doctor/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/doctor/date')) }}">
                                <a href="{{ route('admin.orismos.doctor.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/doctor/index')) }}">
                                <a href="{{ route('admin.orismos.doctor.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                        
                    </li>
                    @endif
                    @if(config('settings.Observer-Orismos'))
                     <li class="{{ active_class(Active::checkUriPattern('admin/orismos/observer/*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Παρατηρητών</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/orismos/observer/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/orismos/observer/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/observer/date')) }}">
                                <a href="{{ route('admin.orismos.observer.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/observer/index')) }}">
                                <a href="{{ route('admin.orismos.observer.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                        
                    </li>
                    @endif
                </ul>
                
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/penalty/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-balance-scale"></i>
                    <span>Ποινές</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/penalty/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/penalty/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/penalty/player/*')) }}">
                        <a href="{{ route('admin.penalty.player.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Ποδοσφαιριστών</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/penalty/team/*')) }}">
                        <a href="{{ route('admin.penalty.team.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Ομάδων</span>
                        </a>
                    </li>
                     <li class="{{ active_class(Active::checkUriPattern('admin/penalty/official/*')) }}">
                        <a href="{{ route('admin.penalty.official.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Αξιωματούχων</span>
                        </a>
                    </li>
                </ul>
                
            </li>
            @endauth
            @permissions([3])
            <li class="{{ active_class(Active::checkUriPattern(['admin/orismos/*', 'admin/grades/*', 'admin/kollimata/*'])) }} treeview">
                <a href="#">
                    <i class="fa fa-flag"></i>
                    <span>Διαιτητές</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern(['admin/orismos/*', 'admin/grades/*', 'admin/kollimata/*', 'admin/prints/referee/*']), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern(['admin/orismos/*', 'admin/grades/*', 'admin/kollimata/*', 'admin/prints/referee/*']), 'display: block;') }}">
                     <li class="{{ active_class(Active::checkUriPattern(['admin/orismos/referee/date','admin/orismos/referee/index'])) }}" treeview>
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Ορισμός Διαιτητών</span>
                        </a>
                         <ul class="treeview-menu {{ active_class(Active::checkUriPattern(['admin/orismos/referee/date','admin/orismos/referee/index']), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern(['admin/orismos/referee/date','admin/orismos/referee/index']), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referee/date')) }}">
                                <a href="{{ route('admin.orismos.referee.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referee/index')) }}">
                                <a href="{{ route('admin.orismos.referee.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                             <li class="{{ active_class(Active::checkUriPattern('admin/prints/referee/orismoi')) }}">
                                <a href="{{ route('admin.prints.referee.orismoi') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Εκτύπωση</span>
                                </a>
                            </li>
                         </ul>
                    </li>

                     @if(config('settings.refObserver-Orismos'))
                   <li class="{{ active_class(Active::checkUriPattern('admin/orismos/refObserver/*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Ορισμός Παρατηρητών Διαιτησίας</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/orismos/refObserver/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/orismos/refObserver/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/refObserver/date')) }}">
                                <a href="{{ route('admin.orismos.refObserver.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/refObserver/index')) }}">
                                <a href="{{ route('admin.orismos.refObserver.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                        
                    </li>
                    @endif
                     <li class="{{ active_class(Active::checkUriPattern('admin/file/referees/*')) }}">
                        <a href="{{ route('admin.file.referees.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Διαιτητές</span>
                        </a>
                    </li>
                     @if(config('settings.refGrades'))
                   <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referees/grades/*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Βαθμολογίες Διαιτητών</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/orismos/referee/grades/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/orismos/referee/grades/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referee/grades/date')) }}">
                                <a href="{{ route('admin.orismos.referee.grades.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/orismos/referee/grades/index')) }}">
                                <a href="{{ route('admin.orismos.referee.grades.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                        
                    </li>
                    @endif
                    <li class="{{ active_class(Active::checkUriPattern('admin/fylla/date*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Στατιστικά</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/fylla/date*')) }}">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Κολλήματα</span>
                        </a>
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/kollimata/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/kollimata/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/kollimata/team/*')) }}">
                                <a href="{{ route('admin.kollimata.team.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ομάδας</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/kollimata/time/*')) }}">
                                <a href="{{ route('admin.kollimata.time.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Χρόνου</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/fylla/date*')) }}">
                        <a href="{{ route('admin.orismos.referee.epoReport') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Μηνιαία Αναφορά προς ΕΠΟ</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth
            @if(config('settings.live'))
                @permissions([5])
                <li class="{{ active_class(Active::checkUriPattern(['admin/live/*'])) }} treeview">
                    <a href="#">
                        <i class="glyphicon glyphicon-flash"></i>
                        <span>Live Αναμετρήσεις</span>
                    </a>
                    <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/live/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/live/*'), 'display: block;') }}">
                   @roles(['Admin'])
                         <li class="{{ active_class(Active::checkUriPattern('admin/live/live/*')) }}" treeview>
                            <a href="#">
                                <i class="fa fa-circle-o"></i>
                                <span>Πρόγραμμα Live Αναμετρήσεων</span>
                            </a>
                             <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/live/live/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/live/live/*'), 'display: block;') }}">
                                <li class="{{ active_class(Active::checkUriPattern('admin/live/live/date')) }}">
                                    <a href="{{ route('admin.live.live.date') }}">
                                        <i class="fa fa-circle-o"></i>
                                        <span>Ανα Ημερομηνία</span>
                                    </a>
                                </li>
                                <li class="{{ active_class(Active::checkUriPattern('admin/live/live/index')) }}">
                                    <a href="{{ route('admin.live.live.index') }}">
                                        <i class="fa fa-circle-o"></i>
                                        <span>Ανά Κατηγορία</span>
                                    </a>
                                </li>
                             </ul>
                        </li>
                    @endauth
                    @roles(['Observer'])
                        <li class="{{ active_class(Active::checkUriPattern('admin/file/referees/*')) }}">
                            <a href="{{ route('admin.file.referees.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>Διαιτητές</span>
                            </a>
                        </li>
                    @endauth
                
                </ul>
            </li>
            @endauth
            @endif
            @permissions([5])
             <li class="{{ active_class(Active::checkUriPattern(['admin/prints/*'])) }} treeview">
                <a href="#">
                    <i class="fa fa-print"></i>
                    <span>Εκτυπώσεις</span>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/exodologia/*')) }} treeview">
                        <a href="#">
                            <i class="fa fa-file"></i>
                            <span>Εξοδολόγια</span>
                        </a>
                       
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/exodologia/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/exodologia/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/exodologia/create')) }}">
                                <a href="{{ route('admin.prints.exodologia.create') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Δημιουργία</span>
                                </a>
                            </li>
                             <li class="{{ active_class(Active::checkUriPattern(['admin/prints/exodologia/date','admin/prints/exodologia/index'])) }}">
                                <a href="#">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Προβολή</span>
                                    </a>
                                    <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/exodologia/date'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern(['admin/prints/exodologia/date','admin/prints/exodologia/index']), 'display: block;') }}">
                                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/exodologia/date')) }}">
                                        <a href="{{ route('admin.prints.exodologia.date') }}">
                                            <i class="fa fa-circle-o"></i>
                                            <span>Ανα Ημερομηνία</span>
                                        </a>
                                    </li>
                                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/exodologia/index')) }}">
                                        <a href="{{ route('admin.prints.exodologia.index') }}">
                                            <i class="fa fa-circle-o"></i>
                                            <span>Ανά Κατηγορία</span>
                                        </a>
                                    </li>
                                 </ul>
                                
                            </li>
                             <li class="{{ active_class(Active::checkUriPattern('admin/prints/exodologia/publish')) }}">
                                <a href="{{ route('admin.prints.exodologia.publish') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Δημοσίευση</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/exodologia/printPerDate')) }}">
                                <a href="{{ route('admin.prints.exodologia.printPerDate') }}">
                                    <i class="fa fa-print"></i>
                                    <span>Εκτύπωση</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @if(config('settings.matchsheets'))
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/*')) }}">
                        <a href="#">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            <span>Φύλλα Αγώνα</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/matchsheets/date'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern(['admin/prints/matchsheets/date','admin/prints/matchsheets/index']), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/date')) }}">
                                <a href="{{ route('admin.prints.matchsheets.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/index')) }}">
                                <a href="{{ route('admin.prints.matchsheets.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                @endif    
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/program/*')) }}">
                        <a href="#">
                            <i class="fa fa-calendar"></i>
                            <span>Πρόγραμμα</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/program/date'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern(['admin/prints/program/date','admin/prints/program/index']), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/program/date')) }}">
                                <a href="{{ route('admin.prints.program.date') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανα Ημερομηνία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/program/index')) }}">
                                <a href="{{ route('admin.prints.program.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ανά Κατηγορία</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/competition/*')) }}">
                        <a href="#">
                            <i class="fa fa-trophy"></i>
                            <span>Διοργανώσεις</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/competition/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern(['admin/prints/competition/*']), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/competition/index')) }}">
                                <a href="{{ route('admin.prints.competition.index')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ομάδες</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/competition/ranking')) }}">
                                <a href="{{ route('admin.prints.competition.ranking')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Βαθμολογία</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/competition/scorer')) }}">
                                <a href="{{ route('admin.prints.competition.scorer')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Σκόρερ</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/competition/sym')) }}">
                                <a href="{{ route('admin.prints.competition.sym')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Συμμετοχές</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/teams/*')) }}">
                        <a href="#">
                            <i class="fa fa-certificate"></i>
                            <span>Σωματεία</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/teams/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/teams/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/teams/index')) }}">
                                <a href="{{ route('admin.prints.teams.index')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Λίστα</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/teams/program')) }}">
                                <a href="{{ route('admin.prints.teams.program')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Αναμετρήσεις Σωματείου</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/teams/players')) }}">
                                <a href="{{ route('admin.prints.teams.players')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ποδοσφαιριστές Σωματείου</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/*')) }}">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>Ποδοσφαιριστές</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/players/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/players/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/players/index')) }}">
                                <a href="{{ route('admin.prints.players.index')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Λίστα</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/players/transfers')) }}">
                                <a href="{{ route('admin.prints.players.transfers')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Μεταγραφές</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/referee/*')) }}">
                        <a href="#">
                            <i class="fa fa-flag"></i>
                            <span>Διαιτητές</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/referee/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/referee/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/referee/index')) }}">
                                <a href="{{ route('admin.prints.referee.index')}}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Λίστα</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/referee/orismoi')) }}">
                                <a href="{{ route('admin.prints.referee.orismoi') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ορισμοί</span>
                                </a>
                            </li>
                            <!--<li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/index')) }}">
                                <a href="#">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ατομικά Στατιστικά</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/index')) }}">
                                <a href="#">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ατομικός Πίνακας Οικονομικών</span>
                                </a>
                            </li>-->
                         </ul>
                    </li>
                     <li class="{{ active_class(Active::checkUriPattern('admin/prints/observer/*')) }}">
                        <a href="#">
                            <i class="glyphicon glyphicon-eye-open"></i>
                            <span>Παρατηρητές</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/observer/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/observer/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/observer/index')) }}">
                                <a href="{{ route('admin.prints.observer.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Λίστα</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/referee/orismoi')) }}">
                                <a href="{{ route('admin.prints.observer.orismoi') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ορισμοί</span>
                                </a>
                            </li>
                            
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/refObserver/*')) }}">
                        <a href="#">
                            <i class="fa fa-binoculars"></i>
                            <span>Παρατηρητές Διαιτησίας</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/refObserver/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/refObserver/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/refObserver/index')) }}">
                                <a href="{{ route('admin.prints.refObserver.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Λίστα</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/refObserver/orismoi')) }}">
                                <a href="{{ route('admin.prints.refObserver.orismoi') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ορισμοί</span>
                                </a>
                            </li>
                           
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/doctor/*')) }}">
                        <a href="#">
                            <i class="fa fa-medkit"></i>
                            <span>Υγειονομικό Προοσωπικό</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/doctor/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/doctor/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/doctor/index')) }}">
                                <a href="{{ route('admin.prints.doctor.index') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Λίστα</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/doctor/orismoi')) }}">
                                <a href="{{ route('admin.prints.doctor.orismoi') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ορισμοί</span>
                                </a>
                            </li>
                            
                         </ul>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/penalties/*')) }}">
                        <a href="#">
                            <i class="fa fa-balance-scale"></i>
                            <span>Ποινές</span>
                            </a>
                            <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/penalties/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/penalties/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/penalties/teamsIndex')) }}">
                                <a href="{{ route('admin.prints.penalties.teamsIndex') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Σωματείου</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/penalties/playersIndex')) }}">
                                <a href="{{ route('admin.prints.penalties.playersIndex') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Ποδοσφαιριστών</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/penalties/officialsIndex')) }}">
                                <a href="{{ route('admin.prints.penalties.officialsIndex') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Αξιωματούχων</span>
                                </a>
                            </li>
                            <li class="{{ active_class(Active::checkUriPattern('admin/prints/penalties/allIndex')) }}">
                                <a href="{{ route('admin.prints.penalties.allIndex') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Συνολικές Ανά Σωματείο</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                </ul>
            </li>
            @endauth
             @needsroles('referee')
             @if(config('settings.matchsheets'))
             <li class="{{ active_class(Active::checkUriPattern('admin/fylla/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span>Φύλλα Αγώνα</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/matchsheets/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/matchsheets/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/my-match-sheet')) }}">
                        <a href="{{ route('admin.prints.matchsheets.my-match-sheet') }}">
                            <i class="fa fa-print"></i>
                            <span>Προσεχή Φύλλα Αγώνα</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/matchsheets/my-last-match-sheet')) }}">
                        <a href="{{ route('admin.prints.matchsheets.my-last-match-sheet') }}">
                            <i class="fa fa-history"></i>
                            <span>Παλαιότερα Φύλλα αγώνα</span>
                        </a>
                    </li>
                </ul>
             </li>
            @endif
             <li class="{{ active_class(Active::checkUriPattern('admin/exodologia/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Εξοδολόγια</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/prints/exodologia/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/prints/exodologia/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/prints/exodologia/next-exodologia*')) }}">
                        <a href="{{ route('admin.prints.exodologia.next-exodologia') }}">
                            <i class="fa fa-print"></i>
                            <span>Προσεχή Εξοδολόγια</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/exodologia/my-last-exodologia*')) }}">
                        <a href="{{ route('admin.prints.exodologia.my-last-exodologia') }}">
                            <i class="fa fa-history"></i>
                            <span>Παλαιότερα Εξοδολόγια</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/program/*')) }} treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-calendar"></i>
                    <span>Πρόγραμμα</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/program/program/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/program/program/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/program/program/myMatches')) }}">
                        <a href="{{ route('admin.program.program.myMatches') }}">
                            <i class="fa fa-history"></i>
                            <span>Οι Αναμετρήσεις μου</span>
                        </a>
                    </li>
                </ul>
             </li>
             <li class="{{ active_class(Active::checkUriPattern('admin/file/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-flag"></i>
                    <span>Διαιτητές</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/file/referees/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/file/referees/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/file/referees/referees')) }}">
                        <a href="{{ route('admin.file.referees.referees') }}">
                            <i class="fa fa-phone"></i>
                            <span>Τηλέφωνα</span>
                        </a>
                    </li>
                </ul>
             </li>
             @if(config('settings.refEducStaf'))
             <li class="{{ active_class(Active::checkUriPattern('admin/file/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-university"></i>
                    <span>Εκπαίδευση</span>
                </a>
               
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/education/referees/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/education/referees/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/education/referees/myeducation')) }}">
                        <a href="{{ route('admin.education.referees.myeducation.index') }}">
                            <i class="fa fa-book"></i>
                            <span>Εκπαιδευτικό υλικό</span>
                        </a>
                    </li>
                </ul>
             </li>
             @endif
            <!--<li class="{{ active_class(Active::checkUriPattern('admin/kollimata/*')) }} treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i>
                            <span>Κολλήματα</span>
                        </a>
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/kollimata/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/kollimata/*'), 'display: block;') }}">
                            <li class="{{ active_class(Active::checkUriPattern('admin/kollimata/time/*')) }}">
                                <a href="{{ route('admin.kollimata.time.myKollimata') }}">
                                    <i class="fa fa-circle-o"></i>
                                    <span>Χρόνου</span>
                                </a>
                            </li>
                         </ul>
                    </li>-->
            @endauth
            @permission(8)
            @if(config('settings.refEducStaf'))
            <li class="{{ active_class(Active::checkUriPattern('admin/fylla/date*')) }}">
                <a href="{{ route('admin.education.referees.index') }}">
                    <i class="fa fa-circle-o"></i>
                    <span>Εκπαιδευτικό Υλικό</span>
                </a>
            </li>
            @endif
            @endauth
            @permission(2)
            <li class="header">{{ trans('menus.backend.sidebar.system') }}</li>

            
            <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Διαχείριση Χρηστών</span>

                    @if ($pending_approval > 0)
                        <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                    @else
                        <i class="fa fa-angle-left pull-right"></i>
                    @endif
                </a>
            
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/access/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                        <a href="{{ route('admin.access.user.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.users.management') }}</span>

                            @if ($pending_approval > 0)
                                <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                            @endif
                        </a>
                    </li>
                @roles(['Administrator'])
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/role*')) }}">
                        <a href="{{ route('admin.access.role.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.roles.management') }}</span>
                        </a>
                    </li>
                @endauth
                </ul>
           
            </li>
           @endauth
            @roles(['Administrator'])
            <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer*')) }} treeview">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer')) }}">
                        <a href="{{ route('log-viewer::dashboard') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.dashboard') }}</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer/logs')) }}">
                        <a href="{{ route('log-viewer::logs.list') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.logs') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>
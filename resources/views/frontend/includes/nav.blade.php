<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#frontend-navbar-collapse">
                <span class="sr-only">{{ trans('labels.general.toggle_navigation') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            {{ link_to_route('frontend.index', app_name(), [], ['class' => 'navbar-brand']) }}
        </div><!--navbar-header-->

        <div class="collapse navbar-collapse" id="frontend-navbar-collapse">
            <ul class="nav navbar-nav">
                
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (config('locale.status') && count(config('locale.languages')) > 1)
                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('menus.language-picker.language') }}
                            <span class="caret"></span>
                        </a>

                        @include('includes.partials.lang')
                    </li>-->
                @endif

                @if ($logged_in_user)
                    <li>{{ link_to_route('frontend.user.dashboard', trans('navs.frontend.dashboard'), [], ['class' => active_class(Active::checkRoute('frontend.user.dashboard')) ]) }}</li>
                @endif

                @if (! $logged_in_user)
                    <li>{{ link_to_route('frontend.auth.login', trans('navs.frontend.login'), [], ['class' => active_class(Active::checkRoute('frontend.auth.login')) ]) }}</li>

                    @if (config('access.users.registration'))
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Εγγραφή <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                        @if (config('settings.referee'))
                           <li>{{ link_to_route('frontend.auth.register', 'Διαιτητής', [], ['class' => active_class(Active::checkRoute('frontend.auth.register')) ]) }}</li>
                        @endif
                        @if (config('settings.observer'))
                           <li>{{ link_to_route('frontend.auth.registerObserver', 'Παρατηρητής', [], ['class' => active_class(Active::checkRoute('frontend.auth.registerObserver')) ]) }}</li>
                        @endif
                        @if (config('settings.teamManager'))
                           <li>{{ link_to_route('frontend.auth.registerTeamManager', 'Υπεύθυνος Ομάδας', [], ['class' => active_class(Active::checkRoute('frontend.auth.registerTeamManager')) ]) }}</li>
                        @endif
                        </ul>
                    </li>
                        
                    @endif
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ $logged_in_user->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @permission('view-backend')
                                <li>{{ link_to_route('admin.dashboard', trans('navs.frontend.user.administration')) }}</li>
                            @endauth
                            <li>{{ link_to_route('frontend.user.account', trans('navs.frontend.user.account'), [], ['class' => active_class(Active::checkRoute('frontend.user.account')) ]) }}</li>
                            <li>{{ link_to_route('frontend.auth.logout', trans('navs.general.logout')) }}</li>
                        </ul>
                    </li>
                @endif

                <li>{{ link_to_route('frontend.contact', trans('navs.frontend.contact'), [], ['class' => active_class(Active::checkRoute('frontend.contact')) ]) }}</li>
            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>
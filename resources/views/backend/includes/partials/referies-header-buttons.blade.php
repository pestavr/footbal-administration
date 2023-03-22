<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.file.referees.index', 'Διαιτητές', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.file.referees.insert', 'Νέος Διαιτητής', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.file.referees.deactivated', 'Μη ενεργοί', [], ['class' => 'btn btn-warning btn-xs']) }}
    {{ link_to_route('admin.file.referees.mass_store', 'Μαζική Δημιουργία Χρηστών', [], ['class' => 'btn btn-warning btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.file.referees.index', 'Διαιτητές') }}</li>
            <li>{{ link_to_route('admin.file.referees.insert', 'Νέος Διαιτητής') }}</li>
            <li>{{ link_to_route('admin.file.referees.mass_store', 'Μαζική Δημιουργία Χρηστών') }}</li>
            <li class="divider"></li>
            <li>{{ link_to_route('admin.file.referees.deactivated', 'Μη ενεργοί') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
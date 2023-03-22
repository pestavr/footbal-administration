<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.file.players.index', 'Ποδοσφαιριστές', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.file.players.insert', 'Νέος ποδοσφαιριστής', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.file.players.uploadPlayersFromFile', 'Εισαγωγή Από Αρχείο', [], ['class' => 'btn btn-danger btn-xs']) }}
    {{ link_to_route('admin.file.players.deactivated', 'Μη ενεργοί', [], ['class' => 'btn btn-warning btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.file.players.index', 'Ποδοσφαιριστές') }}</li>
            <li>{{ link_to_route('admin.file.players.insert', 'Νέος Ποδοσφαιριστής') }}</li>
            <li>{{ link_to_route('admin.file.players.uploadPlayersFromFile', 'Εισαγωγή Από Αρχείο') }}</li>
            <li class="divider"></li>
            <li>{{ link_to_route('admin.file.players.deactivated', 'Μη ενεργοί') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
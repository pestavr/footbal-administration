<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.file.team.index', 'Σωματεία', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.file.players.team', 'Ποδοσφαιριστές', ['id'=>$data['team']], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.move.transfer.transfer', 'Μεταγραφή', ['id'=>$data['team']], ['class' => 'btn btn-warning btn-xs']) }}
    {{ link_to_route('admin.file.players.insertTeamPlayer', 'Νέος ποδοσφαιριστής', ['id'=>$data['team']], ['class' => 'btn btn-success btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.file.team.index', 'Σωματεία') }}</li>
            <li>{{ link_to_route('admin.file.players.team', 'Ποδοσφαιριστές', ['id'=>$data['team']]) }}</li>
            <li>{{ link_to_route('admin.move.transfer.transfer', 'Μεταγραφή', ['id'=>$data['team']]) }}</li>
            <li>{{ link_to_route('admin.file.players.insertTeamPlayer', 'Νέος ποδοσφαιριστής', ['id'=>$data['team']]) }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
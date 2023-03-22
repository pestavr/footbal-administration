<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.kollimata.team.index', 'Κωλύματα με Ομάδες', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.kollimata.team.insert', 'Νέο Κωλύμα με Ομάδες', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.kollimata.team.create', 'Νέο Κωλύμα με Ομάδα', [], ['class' => 'btn btn-success btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.kollimata.team.index', 'Κωλύματα με Ομάδες') }}</li>
            <li>{{ link_to_route('admin.kollimata.team.insert', 'Νέο Κωλύμα με Ομάδες') }}</li>
            <li>{{ link_to_route('admin.kollimata.team.create', 'Νέο Κωλύμα με Ομάδα') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
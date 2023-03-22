<div class="pull-right mb-10 Ενέργειες">
    {{ link_to_route('admin.orismos.referee.index', 'Ανά Αγωνιστική', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.orismos.referee.date', 'Ανά Ημερομηνία', [], ['class' => 'btn btn-danger btn-xs']) }}   
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.orismos.referee.index', 'Ανά Αγωνιστική') }}</li>
            <li>{{ link_to_route('admin.orismos.referee.date', 'Ανά Ημερομηνία') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
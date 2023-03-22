<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.education.referees.myeducation.index', 'Εκπαιδευτικό Υλικό', [], ['class' => 'btn btn-primary btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.education.referees.myeducation.index', 'Εκπαιδευτικό Υλικό') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
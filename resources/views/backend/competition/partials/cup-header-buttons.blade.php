<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.competition.cup.index', 'Κύπελλο', [], ['class' => 'btn btn-success btn-xs']) }}
     {{ link_to_route('admin.competition.cup.deactivated', 'Απενεργοποιημένες Διοργανώσεις', [], ['class' => 'btn btn-info btn-xs']) }}
     {{ link_to_route('admin.competition.cup.cupMatches', 'Νέος Φάση Κυπέλλου', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.competition.cup.regular', 'Νέος Όμιλος', [], ['class' => 'btn btn-danger btn-xs']) }}
    {{ link_to_route('admin.competition.cup.showPlayOff', 'Νέος Όμιλος με Βαθμολογία', [], ['class' => 'btn btn-primary btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.competition.cup.index', 'Κύπελλο') }}</li>
            <li>{{ link_to_route('admin.competition.cup.deactivated', 'Απενεργοποιημένες Διοργανώσεις') }}</li>
            <li>{{ link_to_route('admin.competition.cup.cupMatches', 'Νέος Φάση Κυπέλλου') }}</li>
            <li>{{ link_to_route('admin.competition.cup.regular', 'Νέος Όμιλος') }}</li>
            <li>{{ link_to_route('admin.competition.cup.showPlayOff', 'Νέος Όμιλος με Βαθμούς') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
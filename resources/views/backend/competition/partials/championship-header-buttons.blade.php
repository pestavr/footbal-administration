<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.competition.championship.index', 'Πρωταθλήματα', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.competition.championship.regular', 'Νέος Όμιλος', [], ['class' => 'btn btn-danger btn-xs']) }}
    {{ link_to_route('admin.competition.championship.showPlayOff', 'Νέος Όμιλος Κατάταξης', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.competition.championship.cupMatches', 'Νέα Φάση Πρωταθλήματος', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.competition.championship.friendly', 'Νέα Φιλική Αναμέτρηση', [], ['class' => 'btn btn-danger btn-xs']) }}
    {{ link_to_route('admin.competition.championship.deactivated', 'Απενεργοποιημένοι Όμιλοι', [], ['class' => 'btn btn-info btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.competition.championship.index', 'Πρωταθλήματα') }}</li>
            <li>{{ link_to_route('admin.competition.championship.regular', 'Νέος Όμιλος') }}</li>
            <li>{{ link_to_route('admin.competition.championship.showPlayOff', 'Νέος Όμιλος Κατάταξης') }}</li>
            <li>{{ link_to_route('admin.competition.championship.cupMatches', 'Νέα Φάση Πρωταθλήματος') }}</li>
            <li>{{ link_to_route('admin.competition.championship.friendly', 'Νέα Φιλική Αναμέτρηση') }}</li>
            <li>{{ link_to_route('admin.competition.championship.deactivated', 'Απενεργοποιημένοι Όμιλοι') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
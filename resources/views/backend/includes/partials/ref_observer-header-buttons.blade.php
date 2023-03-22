<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.file.ref_observer.index', 'Παρατηρητές Διατησίας', [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.file.ref_observer.insert', 'Νέος Παρατηρητής Διαιτησίας', [], ['class' => 'btn btn-success btn-xs']) }}
    {{ link_to_route('admin.file.ref_observer.deactivated', 'Μη ενεργοί', [], ['class' => 'btn btn-warning btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           Ενέργειες <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.file.ref_observer.index', 'Παρατηρητές Διατησίας') }}</li>
            <li>{{ link_to_route('admin.file.ref_observer.insert', 'Νέος Παρατηρητής Διαιτησίας')  }}</li>
            <li class="divider"></li>
            <li>{{ link_to_route('admin.file.ref_observer.deactivated', 'Μη ενεργοί') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>
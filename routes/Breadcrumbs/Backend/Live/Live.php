<?php
Breadcrumbs::register('admin.live.live', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Live Αναμετρήσεις Ανά Κατηγορία', route('admin.live.live.index'));
});
Breadcrumbs::register('admin.live.live.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Live Αναμετρήσεις Ανά Κατηγορία', route('admin.live.live.index'));
});
Breadcrumbs::register('admin.live.live.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Live Αναμετρήσεις ανά Ημερομηνία', route('admin.live.live.date'));
});
Breadcrumbs::register('admin.live.live.match', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.live.live');
    $breadcrumbs->push('Επεξεργασία Αναμετρησης', route('admin.live.live.match', $id));
});
Breadcrumbs::register('admin.live.live.matchObserver', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Μετάδοση Αναμετρησης', route('admin.live.live.matchObserver', $id));
});
Breadcrumbs::register('admin.live.live.next-live', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Τα προσεχή εξοδολόγιά μου', route('admin.live.live.next-live'));
});
Breadcrumbs::register('admin.live.live.my-last-live', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Τα προηγούμενα εξοδολόγιά μου', route('admin.live.live.my-last-live'));
});
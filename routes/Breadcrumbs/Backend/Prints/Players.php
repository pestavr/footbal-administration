<?php
Breadcrumbs::register('admin.prints.players', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποδοσφαιριστών', route('admin.prints.players.index'));
});
Breadcrumbs::register('admin.prints.players.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποδοσφαιριστών', route('admin.prints.players.index'));
});
Breadcrumbs::register('admin.prints.players.transfers', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Μεταγραφών', route('admin.prints.players.transfers'));
});
Breadcrumbs::register('admin.prints.players.players', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποδοσφαιριστών Σωματείου', route('admin.prints.players.players'));
});
Breadcrumbs::register('admin.prints.players.scorer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Σκόρερς Ανά Όμιλο', route('admin.prints.players.sym'));
});

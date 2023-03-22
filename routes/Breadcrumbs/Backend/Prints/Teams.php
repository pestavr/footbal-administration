<?php
Breadcrumbs::register('admin.prints.teams', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ομάδων', route('admin.prints.teams.index'));
});
Breadcrumbs::register('admin.prints.teams.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ομάδων', route('admin.prints.teams.index'));
});
Breadcrumbs::register('admin.prints.teams.program', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Αναμετρήσεων Σωματείου', route('admin.prints.teams.program'));
});
Breadcrumbs::register('admin.prints.teams.players', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποδοσφαιριστών Σωματείου', route('admin.prints.teams.players'));
});
Breadcrumbs::register('admin.prints.teams.scorer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Σκόρερς Ανά Όμιλο', route('admin.prints.teams.sym'));
});

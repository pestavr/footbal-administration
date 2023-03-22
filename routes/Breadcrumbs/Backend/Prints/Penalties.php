<?php
Breadcrumbs::register('admin.prints.penalties', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποινών', route('admin.prints.penalties.teamsIndex'));
});
Breadcrumbs::register('admin.prints.penalties.teamsIndex', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποινών Ομάδας', route('admin.prints.penalties.teamsIndex'));
});
Breadcrumbs::register('admin.prints.penalties.playersIndex', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποινών Ποδοσφαιριστών', route('admin.prints.penalties.playersIndex'));
});
Breadcrumbs::register('admin.prints.penalties.officialsIndex', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ποινών Αξιωματούχων', route('admin.prints.penalties.officialsIndex'));
});
Breadcrumbs::register('admin.prints.penalties.allIndex', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση όλων των Ποινών Ανά Σωματείο', route('admin.prints.penalties.allIndex'));
});

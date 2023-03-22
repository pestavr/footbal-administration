<?php
Breadcrumbs::register('admin.program.match', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->parent('admin.program.program.index');
    $breadcrumbs->push('Εισαγωγή Στοιχείων Αναμέτρησης', route('admin.program.match.insert', $id));
});
Breadcrumbs::register('admin.program.match.insert', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->parent('admin.program.program.index');
    $breadcrumbs->push('Εισαγωγή Στοιχείων Αναμέτρησης', route('admin.program.match.insert', $id));
});
Breadcrumbs::register('admin.program.match.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->parent('admin.program.program.index');
    $breadcrumbs->push('Επεξεργασία Στοιχείων Αναμέτρησης', route('admin.program.match.edit', $id));
});



<?php
Breadcrumbs::register('admin.file.referees', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Διαιτητές', route('admin.file.referees.index'));
});
Breadcrumbs::register('admin.file.referees.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Διαιτητές', route('admin.file.referees.index'));
});
Breadcrumbs::register('admin.file.referees.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.referees');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.referees.edit', $id));
});
Breadcrumbs::register('admin.file.referees.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.referees');
    $breadcrumbs->push('Πρόγραμμα', route('admin.file.referees.program', $id));
});
Breadcrumbs::register('admin.file.referees.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.referees');
    $breadcrumbs->push('Εισαγωγή Νέου Διαιτητή', route('admin.file.referees.insert'));
});
Breadcrumbs::register('admin.file.referees.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.referees');
    $breadcrumbs->push('Μη ενεργοί Διαιτητές', route('admin.file.referees.deactivated'));
});
Breadcrumbs::register('admin.file.referees.referees', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Τηλέφωνα Διαιτητών', route('admin.file.referees.referees'));
});
Breadcrumbs::register('admin.file.referees.refStats', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.referees');
    $breadcrumbs->push('Στατιστικά Ανά Διαιτητή', route('admin.file.referees.refStats', $id));
});
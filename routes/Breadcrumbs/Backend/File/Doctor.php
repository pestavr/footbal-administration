<?php
Breadcrumbs::register('admin.file.doctor', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Υγειονομικοί', route('admin.file.doctor.index'));
});
Breadcrumbs::register('admin.file.doctor.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Υγειονομικοί', route('admin.file.doctor.index'));
});
Breadcrumbs::register('admin.file.doctor.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.doctor');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.doctor.edit', $id));
});
Breadcrumbs::register('admin.file.doctor.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.doctor');
    $breadcrumbs->push('Πρόγραμμα', route('admin.file.doctor.program', $id));
});
Breadcrumbs::register('admin.file.doctor.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.doctor');
    $breadcrumbs->push('Εισαγωγή Νέου Υγειονομικού', route('admin.file.doctor.insert'));
});
Breadcrumbs::register('admin.file.doctor.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.doctor');
    $breadcrumbs->push('Μη ενεργοί Υγειονομικοί', route('admin.file.doctor.deactivated'));
});
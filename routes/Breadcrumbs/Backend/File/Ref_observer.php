<?php
Breadcrumbs::register('admin.file.ref_observer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Παρατηρητές Διαιτησίας', route('admin.file.ref_observer.index'));
});
Breadcrumbs::register('admin.file.ref_observer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Παρατηρητές Διαιτησίας', route('admin.file.ref_observer.index'));
});
Breadcrumbs::register('admin.file.ref_observer.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.ref_observer');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.ref_observer.edit', $id));
});
Breadcrumbs::register('admin.file.ref_observer.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.ref_observer');
    $breadcrumbs->push('Πρόγραμμα', route('admin.file.ref_observer.program', $id));
});
Breadcrumbs::register('admin.file.ref_observer.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.ref_observer');
    $breadcrumbs->push('Εισαγωγή Νέου παρατηρητή Διαιτησίας', route('admin.file.ref_observer.insert'));
});
Breadcrumbs::register('admin.file.ref_observer.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.ref_observer');
    $breadcrumbs->push('Μη ενεργοί Παρατηρητές Διαιτησίας', route('admin.file.ref_observer.deactivated'));
});
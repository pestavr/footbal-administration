<?php
Breadcrumbs::register('admin.file.observer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Παρατηρητές', route('admin.file.observer.index'));
});
Breadcrumbs::register('admin.file.observer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Παρατηρητές', route('admin.file.observer.index'));
});
Breadcrumbs::register('admin.file.observer.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.observer');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.observer.edit', $id));
});
Breadcrumbs::register('admin.file.observer.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.observer');
    $breadcrumbs->push('Πρόγραμμα', route('admin.file.observer.program', $id));
});
Breadcrumbs::register('admin.file.observer.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.observer');
    $breadcrumbs->push('Εισαγωγή Νέου παρατηρητή', route('admin.file.observer.insert'));
});
Breadcrumbs::register('admin.file.observer.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.observer');
    $breadcrumbs->push('Μη ενεργοί Παρατηρητές', route('admin.file.observer.deactivated'));
});
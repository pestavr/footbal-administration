<?php
Breadcrumbs::register('admin.orismos.observer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Παρατηρητών Ανά κατηγορία', route('admin.orismos.observer.index'));
});
Breadcrumbs::register('admin.orismos.observer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Παρατηρητών Ανά κατηγορία', route('admin.orismos.observer.index'));
});
Breadcrumbs::register('admin.orismos.observer.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Παρατηρητών Ανά Ημερομηνία', route('admin.orismos.observer.date'));
});


<?php
Breadcrumbs::register('admin.orismos.refObserver', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Παρατηρητών Διαιτησίας Ανά κατηγορία', route('admin.orismos.refObserver.index'));
});
Breadcrumbs::register('admin.orismos.refObserver.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Παρατηρητών Διαιτησίας Ανά κατηγορία', route('admin.orismos.refObserver.index'));
});
Breadcrumbs::register('admin.orismos.refObserver.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Παρατηρητών Διαιτησίας Ανά Ημερομηνία', route('admin.orismos.refObserver.date'));
});


<?php
Breadcrumbs::register('admin.prints.refObserver', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.refObserver.index'));
});
Breadcrumbs::register('admin.prints.refObserver.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.refObserver.index'));
});
Breadcrumbs::register('admin.prints.refObserver.orismoi', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ορισμών Παρατηρητών Διαιτησίας', route('admin.prints.refObserver.orismoi'));
});
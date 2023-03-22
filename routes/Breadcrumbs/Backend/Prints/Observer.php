<?php
Breadcrumbs::register('admin.prints.observer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.observer.index'));
});
Breadcrumbs::register('admin.prints.observer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.observer.index'));
});
Breadcrumbs::register('admin.prints.observer.orismoi', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ορισμών Παρατηρητών', route('admin.prints.observer.orismoi'));
});
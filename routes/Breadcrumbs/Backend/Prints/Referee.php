<?php
Breadcrumbs::register('admin.prints.referee', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.referee.index'));
});
Breadcrumbs::register('admin.prints.referee.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.referee.index'));
});
Breadcrumbs::register('admin.prints.referee.orismoi', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ορισμών Διαιτητών', route('admin.prints.referee.orismoi'));
});
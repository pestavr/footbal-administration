<?php
Breadcrumbs::register('admin.prints.doctor', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.doctor.index'));
});
Breadcrumbs::register('admin.prints.doctor.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Λίστα', route('admin.prints.doctor.index'));
});
Breadcrumbs::register('admin.prints.doctor.orismoi', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ορισμών Υγειονομικού Προσωπικού', route('admin.prints.doctor.orismoi'));
});
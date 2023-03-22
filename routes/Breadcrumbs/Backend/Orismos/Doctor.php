<?php
Breadcrumbs::register('admin.orismos.doctor', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('ΟρισμόςΒοηθητικού Προσωπικού Ανά κατηγορία', route('admin.orismos.doctor.index'));
});
Breadcrumbs::register('admin.orismos.doctor.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('ΟρισμόςΒοηθητικού Προσωπικού Ανά κατηγορία', route('admin.orismos.doctor.index'));
});
Breadcrumbs::register('admin.orismos.doctor.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('ΟρισμόςΒοηθητικού Προσωπικού Ανά Ημερομηνία', route('admin.orismos.doctor.date'));
});


<?php
Breadcrumbs::register('admin.prints.program', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Προγράμματος Ανά Ημερομηνία', route('admin.prints.program.index'));
});
Breadcrumbs::register('admin.prints.program.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Προγράμματος Ανά Ημερομηνία', route('admin.prints.program.index'));
});
Breadcrumbs::register('admin.prints.program.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Προγράμματος Ανά Κατηγορία', route('admin.prints.program.date'));
});

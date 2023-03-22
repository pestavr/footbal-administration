<?php
Breadcrumbs::register('admin.program.program', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Διαχείριση Προγράμματος Ανά κατηγορία', route('admin.program.program.index'));
});
Breadcrumbs::register('admin.program.program.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Διαχείριση Προγράμματος Ανά κατηγορία', route('admin.program.program.index'));
});
Breadcrumbs::register('admin.program.program.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Διαχείριση Προγράμματος Ανά Ημερομηνία', route('admin.program.program.date'));
});
Breadcrumbs::register('admin.program.program.openCourtCheck', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Έλεγχος Γηπέδων', route('admin.program.program.openCourtCheck'));
});
Breadcrumbs::register('admin.program.program.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.program.program');
    $breadcrumbs->push('Εισαγωγή Νέας Μεταγραφής', route('admin.program.program.insert'));
});
Breadcrumbs::register('admin.program.program.myMatches', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Οι αναμετρήσεις μου', route('admin.program.program.myMatches'));
});


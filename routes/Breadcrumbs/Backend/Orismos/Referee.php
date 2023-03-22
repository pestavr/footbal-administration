<?php
Breadcrumbs::register('admin.orismos.referee', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Διαιτητών Ανά κατηγορία', route('admin.orismos.referee.index'));
});
Breadcrumbs::register('admin.orismos.referee.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Διαιτητών Ανά κατηγορία', route('admin.orismos.referee.index'));
});
Breadcrumbs::register('admin.orismos.referee.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ορισμός Διαιτητών Ανά Ημερομηνία', route('admin.orismos.referee.date'));
});
Breadcrumbs::register('admin.orismos.referee.grades.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Βαθμολογία Διαιτητών Ανά κατηγορία', route('admin.orismos.referee.index'));
});
Breadcrumbs::register('admin.orismos.referee.grades.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Βαθμολογία Διαιτητών Ανά Ημερομηνία', route('admin.orismos.referee.date'));
});
Breadcrumbs::register('admin.orismos.referee.epoReport', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Μηνιαία Αναφορά Προς ΕΠΟ', route('admin.orismos.referee.epoReport'));
});

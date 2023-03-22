<?php
Breadcrumbs::register('admin.prints.exodologia', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εξοδολόγια Ανά Κατηγορία', route('admin.prints.exodologia.index'));
});
Breadcrumbs::register('admin.prints.exodologia.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εξοδολόγια Ανά Κατηγορία', route('admin.prints.exodologia.index'));
});
Breadcrumbs::register('admin.prints.exodologia.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Δημιουργία Εξοδολογίων', route('admin.prints.exodologia.create'));
});
Breadcrumbs::register('admin.prints.exodologia.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Προβολή Εξοδολογίων ανά Ημερομηνία', route('admin.prints.exodologia.date'));
});
Breadcrumbs::register('admin.prints.exodologia.publish', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Δημοσίευση Εξοδολογίων', route('admin.prints.exodologia.publish'));
});
Breadcrumbs::register('admin.prints.exodologia.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.prints.exodologia');
    $breadcrumbs->push('Επεξεργασία Εξοδολογίων', route('admin.prints.exodologia.edit', $id));
});
Breadcrumbs::register('admin.prints.exodologia.printPerDate', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Εξοδολογίων', route('admin.prints.exodologia.printPerDate'));
});
Breadcrumbs::register('admin.prints.exodologia.next-exodologia', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Τα προσεχή εξοδολόγιά μου', route('admin.prints.exodologia.next-exodologia'));
});
Breadcrumbs::register('admin.prints.exodologia.my-last-exodologia', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Τα προηγούμενα εξοδολόγιά μου', route('admin.prints.exodologia.my-last-exodologia'));
});
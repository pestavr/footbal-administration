<?php
Breadcrumbs::register('admin.prints.matchsheets', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Φύλλα Αγώνα Ανά Κατηγορία', route('admin.prints.matchsheets.index'));
});
Breadcrumbs::register('admin.prints.matchsheets.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Φύλλα Αγώνα Ανά Κατηγορία', route('admin.prints.matchsheets.index'));
});
Breadcrumbs::register('admin.prints.matchsheets.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Δημιουργία Φύλλων Αγώνων', route('admin.prints.matchsheets.create'));
});
Breadcrumbs::register('admin.prints.matchsheets.date', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Προβολή Φύλλων Αγώνων ανά Ημερομηνία', route('admin.prints.matchsheets.date'));
});
Breadcrumbs::register('admin.prints.matchsheets.publish', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Δημοσίευση Φύλλων Αγώνων', route('admin.prints.matchsheets.publish'));
});
Breadcrumbs::register('admin.prints.matchsheets.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.prints.matchsheets');
    $breadcrumbs->push('Επεξεργασία Φύλλων Αγώνων', route('admin.prints.matchsheets.edit', $id));
});
Breadcrumbs::register('admin.prints.matchsheets.printPerDate', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Φύλλων Αγώνων', route('admin.prints.matchsheets.printPerDate'));
});
Breadcrumbs::register('admin.prints.matchsheets.my-match-sheet', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Τα προσεχή φύλλα αγώνα μου', route('admin.prints.matchsheets.my-match-sheet'));
});
Breadcrumbs::register('admin.prints.matchsheets.my-last-match-sheet', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Τα προηγούμενα φύλλα αγώνα μου', route('admin.prints.matchsheets.my-last-match-sheet'));
});
<?php
Breadcrumbs::register('admin.move.transfer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Μεταγραφές', route('admin.move.transfer.index'));
});
Breadcrumbs::register('admin.move.transfer.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Μεταγραφές', route('admin.move.transfer.index'));
});
Breadcrumbs::register('admin.move.transfer.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.move.transfer');
    $breadcrumbs->push('Επεξεργασία', route('admin.move.transfer.edit', $id));
});
Breadcrumbs::register('admin.move.transfer.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.move.transfer');
    $breadcrumbs->push('Πρόγραμμα', route('admin.move.transfer.program', $id));
});
Breadcrumbs::register('admin.move.transfer.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.move.transfer');
    $breadcrumbs->push('Εισαγωγή Νέας Μεταγραφής', route('admin.move.transfer.insert'));
});
Breadcrumbs::register('admin.move.transfer.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.move.transfer');
    $breadcrumbs->push('Μη ενεργοί Μεταγραφές', route('admin.move.transfer.deactivated'));
});
Breadcrumbs::register('admin.move.players.transfer', function ($breadcrumbs,$id) {
    $breadcrumbs->parent('admin.move.transfer');
    $breadcrumbs->push('Ποδοσφαιριστές Σωματείου', route('admin.move.players.transfer', $id));
});
Breadcrumbs::register('admin.move.transfer.transfer', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Ποδοσφαιριστές',route('admin.file.players.team', $id));
    $breadcrumbs->push('Μεταγραφή Ποδοσφαιριστή', route('admin.move.transfer.transfer', $id));
});
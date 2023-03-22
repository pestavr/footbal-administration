<?php
Breadcrumbs::register('admin.file.team', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Σωματεία', route('admin.file.team.index'));
});
Breadcrumbs::register('admin.file.team.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Σωματεία', route('admin.file.team.index'));
});
Breadcrumbs::register('admin.file.team.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.team.edit', $id));
});
Breadcrumbs::register('admin.file.team.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Πρόγραμμα', route('admin.file.team.program', $id));
});
Breadcrumbs::register('admin.file.team.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Εισαγωγή Νέου Σωματείου', route('admin.file.team.insert'));
});
Breadcrumbs::register('admin.file.team.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Μη ενεργοί Σωματεία', route('admin.file.team.deactivated'));
});
Breadcrumbs::register('admin.file.players.team', function ($breadcrumbs,$id) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Ποδοσφαιριστές Σωματείου', route('admin.file.players.team', $id));
});
Breadcrumbs::register('admin.file.teamsAccountable.team', function ($breadcrumbs,$id) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Υπόλογοι Σωματείου', route('admin.file.teamsAccountable.team', $id));
});
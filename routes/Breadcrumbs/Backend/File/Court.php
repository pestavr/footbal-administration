<?php
Breadcrumbs::register('admin.file.court', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Γήπεδα', route('admin.file.court.index'));
});
Breadcrumbs::register('admin.file.court.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Γήπεδα', route('admin.file.court.index'));
});
Breadcrumbs::register('admin.file.court.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.court');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.court.edit', $id));
});
Breadcrumbs::register('admin.file.court.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.court');
    $breadcrumbs->push('Πρόγραμμα', route('admin.file.court.program', $id));
});
Breadcrumbs::register('admin.file.court.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.court');
    $breadcrumbs->push('Εισαγωγή Νέου Γηπέδου', route('admin.file.court.insert'));
});
Breadcrumbs::register('admin.file.court.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.court');
    $breadcrumbs->push('Μη ενεργοί Γήπεδα', route('admin.file.court.deactivated'));
});
Breadcrumbs::register('admin.file.court.map', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.court');
    $breadcrumbs->push('Επεξεργασία Χάρτη', route('admin.file.court.map', $id));
});
Breadcrumbs::register('admin.file.court.cities', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.court');
    $breadcrumbs->push('Επεξεργασία Χάρτη', route('admin.file.court.cities', $id));
});
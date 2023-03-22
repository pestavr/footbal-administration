<?php
Breadcrumbs::register('admin.penalty.official', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποινές Αξιωματούχων', route('admin.penalty.official.index'));
});
Breadcrumbs::register('admin.penalty.official.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποινές Αξιωματούχων', route('admin.penalty.official.index'));
});
Breadcrumbs::register('admin.penalty.official.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.penalty.official');
    $breadcrumbs->push('Επεξεργασία Ποινής Αξιωματούχων', route('admin.penalty.official.edit', $id));
});
Breadcrumbs::register('admin.penalty.official.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.penalty.official');
    $breadcrumbs->push('Εισαγωγή Νέας Ποινής Αξιωματούχου', route('admin.penalty.official.insert'));
});

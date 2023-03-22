<?php
Breadcrumbs::register('admin.penalty.team', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποινές Ομάδων', route('admin.penalty.team.index'));
});
Breadcrumbs::register('admin.penalty.team.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποινές Ομάδων', route('admin.penalty.team.index'));
});
Breadcrumbs::register('admin.penalty.team.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.penalty.team');
    $breadcrumbs->push('Επεξεργασία Ποινής Ομάδων', route('admin.penalty.team.edit', $id));
});
Breadcrumbs::register('admin.penalty.team.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.penalty.team');
    $breadcrumbs->push('Εισαγωγή Νέας Ποινής Ομάδας', route('admin.penalty.team.insert'));
});

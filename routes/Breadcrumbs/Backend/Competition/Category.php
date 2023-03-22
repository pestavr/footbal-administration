<?php
Breadcrumbs::register('admin.competition.category', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κατηγορίες', route('admin.competition.category.index'));
});
Breadcrumbs::register('admin.competition.category.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κατηγορίες', route('admin.competition.category.index'));
});
Breadcrumbs::register('admin.competition.category.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.category');
    $breadcrumbs->push('Επεξεργασία', route('admin.competition.category.edit', $id));
});
Breadcrumbs::register('admin.competition.category.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.category');
    $breadcrumbs->push('Πρόγραμμα', route('admin.competition.category.program', $id));
});
Breadcrumbs::register('admin.competition.category.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.category');
    $breadcrumbs->push('Εισαγωγή Νέου Διαιτητή', route('admin.competition.category.insert'));
});
Breadcrumbs::register('admin.competition.category.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.category');
    $breadcrumbs->push('Μη ενεργοί Κατηγορίες', route('admin.competition.category.deactivated'));
});
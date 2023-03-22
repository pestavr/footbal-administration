<?php
Breadcrumbs::register('admin.file.teamsAccountable', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Υπόλογοι Ομάδας', route('admin.file.teamsAccountable.index'));
});
Breadcrumbs::register('admin.file.teamsAccountable.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Υπόλογοι Ομάδας', route('admin.file.teamsAccountable.index'));
});
Breadcrumbs::register('admin.file.teamsAccountable.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.teamsAccountable');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.teamsAccountable.edit', $id));
});
Breadcrumbs::register('admin.file.teamsAccountable.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.teamsAccountable');
    $breadcrumbs->push('Εισαγωγή Νέου Υπόλογου Ομάδας', route('admin.file.teamsAccountable.insert'));
});
Breadcrumbs::register('admin.file.teamsAccountable.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.teamsAccountable');
    $breadcrumbs->push('Μη ενεργοί Υπόλογοι Ομάδας', route('admin.file.teamsAccountable.deactivated'));
});
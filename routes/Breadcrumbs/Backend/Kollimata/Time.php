<?php
Breadcrumbs::register('admin.kollimata.time', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κωλύματα Χρόνου', route('admin.kollimata.time.index'));
});
Breadcrumbs::register('admin.kollimata.time.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κωλύματα Χρόνου', route('admin.kollimata.time.index'));
});
Breadcrumbs::register('admin.kollimata.time.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.kollimata.time');
    $breadcrumbs->push('Επεξεργασία Κωλύματος Χρόνου', route('admin.kollimata.time.edit', $id));
});
Breadcrumbs::register('admin.kollimata.time.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.kollimata.time');
    $breadcrumbs->push('Εισαγωγή Νέου Κωλύματος Χρόνου', route('admin.kollimata.time.insert'));
});
Breadcrumbs::register('admin.kollimata.time.myKollimata', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κωλύματα Χρόνου', route('admin.kollimata.time.myKollimata'));
});

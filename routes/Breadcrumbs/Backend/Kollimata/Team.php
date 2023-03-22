<?php
Breadcrumbs::register('admin.kollimata.team', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κωλύματα Ομάδας', route('admin.kollimata.team.index'));
});
Breadcrumbs::register('admin.kollimata.team.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κωλύματα Ομάδας', route('admin.kollimata.team.index'));
});
Breadcrumbs::register('admin.kollimata.team.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.kollimata.team');
    $breadcrumbs->push('Επεξεργασία Κωλύματος  Ομάδας', route('admin.kollimata.team.edit', $id));
});
Breadcrumbs::register('admin.kollimata.team.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.kollimata.team');
    $breadcrumbs->push('Εισαγωγή Νέου Κωλύματος  Ομάδας', route('admin.kollimata.team.insert'));
});
Breadcrumbs::register('admin.kollimata.team.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.kollimata.team');
    $breadcrumbs->push('Εισαγωγή Νέου Κωλύματος  Ομάδας', route('admin.kollimata.team.create'));
});

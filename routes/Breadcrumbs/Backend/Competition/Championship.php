<?php
Breadcrumbs::register('admin.competition.championship', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Πρωταθλήματα', route('admin.competition.championship.index'));
});
Breadcrumbs::register('admin.competition.championship.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Πρωταθλήματα', route('admin.competition.championship.index'));
});
Breadcrumbs::register('admin.competition.championship.regular', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Νέος Όμιλος Πρωταθλήματος', route('admin.competition.championship.regular'));
});
Breadcrumbs::register('admin.competition.championship.showPlayOff', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Νέος Όμιλος Κατάταξης', route('admin.competition.championship.showPlayOff'));
});
Breadcrumbs::register('admin.competition.championship.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Επεξεργασία Ομίλου', route('admin.competition.championship.edit', $id));
});
Breadcrumbs::register('admin.competition.championship.draw', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Κλήρωση Ομίλου', route('admin.competition.championship.draw', $id));
});
Breadcrumbs::register('admin.competition.championship.changeTeams', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Αλλαγή Ομάδων Ομίλου', route('admin.competition.championship.changeTeams', $id));
});
Breadcrumbs::register('admin.competition.championship.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Απενεργοποιημένοι Όμιλοι', route('admin.competition.championship.deactivated'));
});
Breadcrumbs::register('admin.competition.championship.tiebrake', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Κλήρωση Ομίλου', route('admin.competition.championship.tiebrake', $id));
});
Breadcrumbs::register('admin.competition.championship.cupMatches', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Νέα Φάση Πρωταθλήματος', route('admin.competition.championship.cupMatches'));
});
Breadcrumbs::register('admin.competition.championship.friendly', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.championship.index');
    $breadcrumbs->push('Νέα Αναμέτρηση', route('admin.competition.championship.friendly'));
});
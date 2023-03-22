<?php
Breadcrumbs::register('admin.competition.cup', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κύπελλο', route('admin.competition.cup.index'));
});
Breadcrumbs::register('admin.competition.cup.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Κύπελλο', route('admin.competition.cup.index'));
});
Breadcrumbs::register('admin.competition.cup.regular', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Νέος Όμιλος Πρωταθλήματος', route('admin.competition.cup.regular'));
});
Breadcrumbs::register('admin.competition.cup.showPlayOff', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Νέος Όμιλος Κατάταξης', route('admin.competition.cup.showPlayOff'));
});
Breadcrumbs::register('admin.competition.cup.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Επεξεργασία Ομίλου', route('admin.competition.cup.edit', $id));
});
Breadcrumbs::register('admin.competition.cup.draw', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Κλήρωση Ομίλου', route('admin.competition.cup.draw', $id));
});
Breadcrumbs::register('admin.competition.cup.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Απενεργοποιημένοι Όμιλοι', route('admin.competition.cup.deactivated'));
});
Breadcrumbs::register('admin.competition.cup.tiebrake', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Κλήρωση Ομίλου', route('admin.competition.cup.tiebrake', $id));
});
Breadcrumbs::register('admin.competition.cup.cupMatches', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Νέος Φάση Κυπέλλου', route('admin.competition.cup.cupMatches'));
});
Breadcrumbs::register('admin.competition.cup.changeTeams', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.competition.cup.index');
    $breadcrumbs->push('Αλλαγή Ομάδων Ομίλου', route('admin.competition.cup.changeTeams', $id));
});
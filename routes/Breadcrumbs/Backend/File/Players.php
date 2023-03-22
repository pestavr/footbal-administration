<?php
Breadcrumbs::register('admin.file.players', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποδοσφαιριστές', route('admin.file.players.index'));
});
Breadcrumbs::register('admin.file.players.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποδοσφαιριστές', route('admin.file.players.index'));
});
Breadcrumbs::register('admin.file.players.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.players');
    $breadcrumbs->push('Επεξεργασία', route('admin.file.players.edit', $id));
});
Breadcrumbs::register('admin.file.players.program', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.players');
    $breadcrumbs->push('Πρόγραμμα', route('admin.file.players.program', $id));
});
Breadcrumbs::register('admin.file.players.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.players');
    $breadcrumbs->push('Εισαγωγή Νέου Ποδοσφαιριστή', route('admin.file.players.insert'));
});
Breadcrumbs::register('admin.file.players.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.players');
    $breadcrumbs->push('Μη ενεργοί Ποδοσφαιριστές', route('admin.file.players.deactivated'));
});
Breadcrumbs::register('admin.file.players.insertTeamPlayer', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.file.team');
    $breadcrumbs->push('Ποδοσφαιριστές',route('admin.file.players.team', $id));
    $breadcrumbs->push('Εισαγωγή Νέου Ποδοσφαιριστή', route('admin.file.players.insertTeamPlayer', $id));
});
Breadcrumbs::register('admin.file.players.uploadPlayersFromFile', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.file.players');
    $breadcrumbs->push('Μη ενεργοί Ποδοσφαιριστές', route('admin.file.players.uploadPlayersFromFile'));
});

<?php
Breadcrumbs::register('admin.penalty.player', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποινές Ποδοσφαιριστών', route('admin.penalty.player.index'));
});
Breadcrumbs::register('admin.penalty.player.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Ποινές Ποδοσφαιριστών', route('admin.penalty.player.index'));
});
Breadcrumbs::register('admin.penalty.player.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.penalty.player');
    $breadcrumbs->push('Επεξεργασία Ποινής Ποδοσφαιριστών', route('admin.penalty.player.edit', $id));
});
Breadcrumbs::register('admin.penalty.player.insert', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.penalty.player');
    $breadcrumbs->push('Εισαγωγή Νέας Ποινής Ποδοσφαιριστή', route('admin.penalty.player.insert'));
});
Breadcrumbs::register('admin.penalty.player.insertRedPenalty', function ($breadcrumbs, $id, $match) {
    $breadcrumbs->parent('admin.penalty.player');
    $breadcrumbs->push('Επεξεργασία Ποινής Ποδοσφαιριστών', route('admin.penalty.player.insertRedPenalty', ['id'=>$id, 'match'=>$match]));
});
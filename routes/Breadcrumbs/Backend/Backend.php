<?php

Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(trans('strings.backend.dashboard.title'), route('admin.dashboard'));
});
Breadcrumbs::register('admin.edit', function ($breadcrumbs, $id) {
	$breadcrumbs->parent('admin.dashboard');
     $breadcrumbs->push('Επεξεργασία Ένωσης Ποδοσφαιρικών Σωματείων', route('admin.edit', $id));
});

require __DIR__.'/Search.php';
require __DIR__.'/Access.php';
require __DIR__.'/LogViewer.php';
require __DIR__.'/File.php';
require __DIR__.'/Movement.php';
require __DIR__.'/Program.php';
require __DIR__.'/Penalty.php';
require __DIR__.'/Orismos.php';
require __DIR__.'/Competition.php';
require __DIR__.'/Prints.php';
require __DIR__.'/Season.php';
require __DIR__.'/Live.php';
require __DIR__.'/Kollimata.php';
require __DIR__.'/Education.php';
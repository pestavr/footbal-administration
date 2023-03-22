<?php

Breadcrumbs::register('admin.season.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Δημιουργία Νέας Αγωνιστικής Περιόδου', route('admin.season.create'));
});
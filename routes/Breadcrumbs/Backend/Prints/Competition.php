<?php
Breadcrumbs::register('admin.prints.competition', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ομάδων Ανά Όμιλο', route('admin.prints.competition.index'));
});
Breadcrumbs::register('admin.prints.competition.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Ομάδων Ανά Όμιλο', route('admin.prints.competition.index'));
});
Breadcrumbs::register('admin.prints.competition.ranking', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Βαθμολογίας Ανά Όμιλο', route('admin.prints.competition.ranking'));
});
Breadcrumbs::register('admin.prints.competition.sym', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Συμμετοχής Ανά Όμιλο', route('admin.prints.competition.sym'));
});
Breadcrumbs::register('admin.prints.competition.scorer', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκτύπωση Σκόρερς Ανά Όμιλο', route('admin.prints.competition.sym'));
});

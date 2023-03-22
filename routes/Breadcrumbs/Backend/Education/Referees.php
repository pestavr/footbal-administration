<?php
Breadcrumbs::register('admin.education.referees.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκπαίδευση Διαιτητών', route('admin.education.referees.index'));
});
Breadcrumbs::register('admin.education.referees.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.education.referees.index');
    $breadcrumbs->push('Επεξεργασία', route('admin.education.referees.edit', $id));
});
Breadcrumbs::register('admin.education.referees.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.education.referees.index');
    $breadcrumbs->push('Εισαγωγή Νέου Εκπαιδευτικού Υλικού', route('admin.education.referees.create'));
});
Breadcrumbs::register('admin.education.referees.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.education.referees.index');
    $breadcrumbs->push('Μη ενεργές Εκπαιδεύσεις', route('admin.education.referees.deactivated'));
});
Breadcrumbs::register('admin.education.referees.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.education.referees.index');
    $breadcrumbs->push('Εκπαίδευση', route('admin.education.referees.show', $id));
});
Breadcrumbs::register('admin.education.referees.answers.index', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.education.referees.index');
    $breadcrumbs->push('Απαντήσεις στην Ερώτηση', route('admin.education.referees.answers.index', $id));
});
/**
 * My Education
 */

Breadcrumbs::register('admin.education.referees.myeducation.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push('Εκπαίδευση Διαιτητών', route('admin.education.referees.myeducation.index'));
});

Breadcrumbs::register('admin.education.referees.myeducation.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.education.referees.myeducation.index');
    $breadcrumbs->push('Εκπαιδευτικό Υλικό', route('admin.education.referees.myeducation.show', $id));
});

<?php

Breadcrumbs::register('admin.auth.commission.pending', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(__('labels.backend.access.commission.management'), route('admin.auth.commission.pending'));
});
Breadcrumbs::register('admin.auth.commission.payment', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(__('labels.backend.access.commission.management'), route('admin.auth.commission.payment'));
});
Breadcrumbs::register('admin.auth.commission.completed', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(__('labels.backend.access.commission.management'), route('admin.auth.commission.completed'));
});

<?php

Breadcrumbs::register('admin.auth.admin.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(__('labels.backend.access.admins.management'), route('admin.auth.admin.index'));
});

Breadcrumbs::register('admin.auth.admin.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.admin.index');
    $breadcrumbs->push(__('menus.backend.access.admins.deactivated'), route('admin.auth.admin.deactivated'));
});

Breadcrumbs::register('admin.auth.admin.deleted', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.admin.index');
    $breadcrumbs->push(__('menus.backend.access.admins.deleted'), route('admin.auth.admin.deleted'));
});

Breadcrumbs::register('admin.auth.admin.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.admin.index');
    $breadcrumbs->push(__('labels.backend.access.admins.create'), route('admin.auth.admin.create'));
});

Breadcrumbs::register('admin.auth.admin.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.admin.index');
    $breadcrumbs->push(__('menus.backend.access.admins.view'), route('admin.auth.admin.show', $id));
});

Breadcrumbs::register('admin.auth.admin.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.admin.index');
    $breadcrumbs->push(__('menus.backend.access.admins.edit'), route('admin.auth.admin.edit', $id));
});

Breadcrumbs::register('admin.auth.admin.change-password', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.admin.index');
    $breadcrumbs->push(__('menus.backend.access.admins.change-password'), route('admin.auth.admin.change-password', $id));
});

<?php


use Diglactic\Breadcrumbs\Breadcrumbs;


use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('home'));
});

Breadcrumbs::for('breadcrumbsFrontendCompany', function (BreadcrumbTrail $trail, $breadcrumbs) {
    $trail->parent('home');

    foreach ($breadcrumbs as $breadcrumb) {
        $trail->push($breadcrumb['route_title'], route($breadcrumb['route_name'], $breadcrumb['route_parameter']));
    }
});
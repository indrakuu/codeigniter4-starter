<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// $routes->addRedirect('/', '/login');

$routes->get('/dashboard', 'Admin\AdminController::index', ['as' => 'dashboard', 'filter' => 'login']);
$routes->group('',['filter' => 'login'], function ($routes) {
    $routes->group('dashboard', function ($routes) {

        // Routes for Profile
        $routes->get('profile', 'Admin\ProfileController::index', ['filter'=> 'permission:manage-user','as' => 'profile']);
        $routes->post('profile', 'Admin\ProfileController::update', ['filter'=> 'permission:manage-user','as' => 'profile.updateProfile']);
        $routes->get('profile/password', 'Admin\ProfileController::changePassword', ['filter'=> 'permission:manage-user', 'as' => 'profile.changePassword']);
        $routes->post('profile/password', 'Admin\ProfileController::updatePassword', ['filter'=> 'permission:manage-user', 'as' => 'profile.updatePassword']);

        // Routes for User
        $routes->get('user', 'Admin\UserController::index', ['filter' => 'permission:back-office', 'as' => 'user.index']);
        $routes->get('user/create', 'Admin\UserController::create', ['filter' => 'permission:back-office', 'as' => 'user.create']);
        $routes->post('user/create', 'Admin\UserController::store', ['filter' => 'permission:back-office', 'as' => 'user.store']);

        $routes->post('user/searchUser', 'Admin\UserController::searchUser', ['filter' => 'permission:back-office', 'as' =>'user.search']);
        $routes->get('user/(:num)', 'Admin\UserController::show/$1', ['filter' => 'permission:back-office', 'filter' => 'permission:back-office', 'as' => 'user.show']);
        $routes->post('user/(:num)', 'Admin\UserController::update/$1', ['filter' => 'permission:back-office', 'as' => 'user.update']);
        $routes->get('user/(:num)/password', 'Admin\UserController::changePassword/$1', ['filter' => 'permission:back-office', 'as' => 'user.changePassword']);
        $routes->post('user/(:num)/password', 'Admin\UserController::updatePassword/$1', ['filter' => 'permission:back-office', 'as' => 'user.updatePassword']);
        $routes->delete('user/(:num)/delete', 'Admin\UserController::delete/$1', ['filter' => 'permission:back-office', 'as' => 'user.delete']);

        // Routes for Role
        $routes->get('role', 'Admin\RoleController::index', ['filter' => 'permission:role-permission','as' => 'role.index']);
        $routes->post('role/searchRole', 'Admin\RoleController::searchRole', ['filter' => 'permission:role-permission', 'as' =>'role.search']);
        $routes->get('role/create', 'Admin\RoleController::create', ['filter' => 'permission:role-permission', 'as' => 'role.create']);
        $routes->post('role/create', 'Admin\RoleController::store', ['filter' => 'permission:role-permission', 'as' => 'role.store']);
        $routes->get('role/(:num)', 'Admin\RoleController::show/$1', ['filter' => 'permission:role-permission', 'as' => 'role.show']);
        $routes->post('role/(:num)', 'Admin\RoleController::update/$1', ['filter' => 'permission:role-permission', 'as' => 'role.update']);
        $routes->delete('role/(:num)/delete', 'Admin\RoleController::delete/$1', ['filter' => 'permission:role-permission', 'as' => 'role.delete']);

        // Routes for Permissions
        $routes->get('permission', 'Admin\PermissionController::index', ['filter' => 'permission:role-permission', 'as' => 'permission.index']);
        $routes->post('permission/searchPermission', 'Admin\PermissionController::searchPermission', ['filter' => 'permission:role-permission', 'as' =>'permission.search']);
        $routes->post('permission', 'Admin\PermissionController::store', ['filter' => 'permission:role-permission', 'as' => 'permission.store']);
        $routes->get('permission/(:num)', 'Admin\PermissionController::show/$1', ['filter' => 'permission:role-permission', 'as' => 'permission.show']);
        $routes->delete('permission/(:num)/delete', 'Admin\PermissionController::delete/$1', ['filter' => 'permission:role-permission', 'as' => 'permission.delete']);

        // Routes for Menu
        $routes->get('menu', 'Admin\MenuController::index', ['filter'=>'permission:menu-permission', 'as' => 'menu.index']);
        $routes->post('menu', 'Admin\MenuController::store', ['filter'=>'permission:menu-permission', 'as' => 'menu.store']);
        $routes->get('menu/(:num)', 'Admin\MenuController::show/$1', ['filter'=>'permission:menu-permission', 'as' => 'menu.show']);
        $routes->post('menu/(:num)', 'Admin\MenuController::update/$1', ['filter'=>'permission:menu-permission', 'as' =>'menu.update']);

        $routes->delete('menu/(:num)', 'Admin\MenuController::delete/$1', ['filter'=>'permission:menu-permission', 'as' => 'menu.delete']);
        $routes->post('menu/list-update', 'Admin\MenuController::listMenu', ['filter'=>'permission:menu-permission', 'as' => 'menu.list']);
        
    });
});

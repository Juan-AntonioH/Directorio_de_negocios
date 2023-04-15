<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Backend\Middlewares\AuthMiddleware;
use App\Backend\Controllers\DashboardController;
use App\Backend\Controllers\PrivateImageController;
use App\Backend\Controllers\Auth\LoginGetController;
use App\Backend\Controllers\Auth\LoginPostController;
use App\Backend\Controllers\Auth\LogoutPostController;
use App\Backend\Controllers\Auth\RegisterGetController;
use App\Backend\Controllers\Auth\RegisterPostController;
use App\Backend\Controllers\ExecuteMigrationsController;
use App\Backend\Controllers\Users\UsersEditGetController;
use App\Backend\Controllers\Users\UsersListGetController;
use App\Backend\Controllers\User\EditAccountGetController;
use App\Backend\Controllers\Users\UsersEditPostController;
use App\Backend\Controllers\User\EditAccountPostController;
use App\Backend\Controllers\User\ChangePasswordPostController;
use App\Backend\Controllers\Company\CompanyDeletePostController;
use App\Backend\Controllers\Auth\SigInWithInvitationGetController;
use App\Backend\Controllers\Auth\SigInWithInvitationPostController;
use App\Backend\Controllers\Users\UsersCreateInvitationGetController;
use App\Backend\Controllers\Users\UsersCreateInvitationPostController;
use App\Backend\Controllers\Users\UsersDeleteInvitationPostController;

/*
 * BACKEND APP ROUTES
 */

return function (App $app) {
    // $app->group('/ctc', function (RouteCollectorProxy $group) {
        /* Public ROUTES */
        $app->group('', function (RouteCollectorProxy $group) {
            $group->group('', function (RouteCollectorProxy $group) {
            // $group->get('', DashboardController::class)->setName('dashboard');           
            $group->get('/login', LoginGetController::class)->setName('auth.get.login');
            $group->post('/login', LoginPostController::class)->setName('auth.post.login');
            $group->get('/register', RegisterGetController::class)->setName('auth.get.register');
            $group->post('/register', RegisterPostController::class)->setName('auth.post.register');
            $group->post('/logout', LogoutPostController::class)->setName('auth.get.logout');
            $group->get('/empresa/view/{id}', CompanyGetController::class)->setName('company.get.view');
            // $group->get('/sigin/invitation/{token}', SigInWithInvitationGetController::class)->setName('auth.get.sigin.withInvitation');
            // $group->post('/sigin/invitation/{token}', SigInWithInvitationPostController::class)->setName('auth.post.sigin.withInvitation');

            /* MIGRATIONS */
            $group->get('/executeMigrations/{token}[/{first}]', ExecuteMigrationsController::class);
        });

        /* Authenticated ROUTES */
        $group->group('', function (RouteCollectorProxy $group) {
            $group->get('/empresa/vote/{id}', CompanyGetController::class)->setName('company.post.vote');
            $group->get('/empresa/create', CompanyCreateGetController::class)->setName('company.get.create');
            $group->post('/empresa/create', CompanyCreatePostController::class)->setName('company.post.create');
            $group->get('/empresa/{id}', CompanyEditGetController::class)->setName('company.get.edit');
            $group->post('/empresa/{id}', CompanyEdotPostController::class)->setName('company.post.edit');
            $group->post('/empresa/delete/{id}', CompanyDeletePostController::class)->setName('company.post.delete')->setArgument('roles','admin');
                    // $group->get('/dashboard', DashboardController::class)->setName('dashboard');
                    // $group->post('/logout', LogoutPostController::class)->setName('auth.get.logout');

                    /* User account ROUTES */
                    // $group->get('/account', EditAccountGetController::class)->setName('user.edit.account');
                    // $group->post('/account', EditAccountPostController::class)->setName('post.user.edit.account');
                    // $group->post('/account/changePassword', ChangePasswordPostController::class)->setName('post.user.edit.account.changePassword');

                    /* Users Management ROUTES */
                    // $group->get('/users', UsersListGetController::class)->setName('users.list')->setArgument('roles', 'admin');
                    // $group->get('/users/{id_user}', UsersEditGetController::class)->setName('users-management.get.edit')->setArgument('roles', 'admin');
                    // $group->post('/users/{id_user}', UsersEditPostController::class)->setName('users-management.post.edit')->setArgument('roles', 'admin');
        //                   $this->post('/users/{id_user}/changePassword', UsersChangePasswordPostController::class)->setName('users-management.post.changePassword')->setArgument('roles', 'admin');
                    // $group->get('/usersInvitation', UsersCreateInvitationGetController::class)->setName('users-management.get.createInvitation')->setArgument('roles', 'admin');
                    // $group->post('/usersInvitation', UsersCreateInvitationPostController::class)->setName('users-management.post.createInvitation')->setArgument('roles', 'admin');
                    // $group->post('/usersInvitation/{id_invitation}/delete', UsersDeleteInvitationPostController::class)->setName('users-management.post.deleteInvitation')->setArgument('roles', 'admin');

            /* Helpers ROUTES */
            $group->get('/img/{type}/{file}', PrivateImageController::class)->setName('get.private.image');
        })->add(AuthMiddleware::class);
    });
};

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function() {
    return str_random(32);
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register',  ['uses' => 'AuthUserController@register']);
    $router->post('login', ['uses' => 'AuthUserController@login']);

    $router->group(['middleware' => 'auth'], function () use ($router){
        /**
         * Routes for resource item
         */
        $router->get('item/complete', 'ItemsController@complete_item');
        $router->get('item/incomplete', 'ItemsController@incomplete_item');
        $router->get('item/checklist/{checklist}', 'ItemsController@item_with_checklist');
        $router->get('item/{itemid}/checklist/{checklistid}', 'ItemsController@get_checklist_item');
        $router->post('item/checklist/{checklist}', 'ItemsController@create_checklist_item');
        $router->delete('item/{itemid}/checklist/{checklistid}','ItemsController@destroy');
        $router->put('item/{itemid}/checklist/{checklistid}', 'ItemsController@put'); 
        
        /**
         * Routes for resource template
         */
        $router->get('template', 'TemplatesController@all');
        $router->get('template/{id}', 'TemplatesController@get');
        $router->post('template', 'TemplatesController@add');
        $router->put('template/{id}', 'TemplatesController@put');
        $router->delete('template/{id}', 'TemplatesController@remove');

        /**
         * Routes for resource checklist
         */
        $router->get('checklist', 'ChecklistsController@all');
        $router->get('checklist/{id}', 'ChecklistsController@get');
        $router->post('checklist', 'ChecklistsController@add');
        $router->put('checklist/{id}', 'ChecklistsController@put');
        $router->delete('checklist/{id}', 'ChecklistsController@remove');
    });
});


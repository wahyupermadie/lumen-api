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

        $router->get('item/{id}', 'ItemsController@get');
        $router->post('item', 'ItemsController@add');
        $router->put('item/{id}', 'ItemsController@put');
        $router->delete('item/{id}', 'ItemsController@remove');  
    });
});

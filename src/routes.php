<?php

Route::group(['namespace' => 'Pila\ClientManager\Controllers', 'as' => 'pila::', 'prefix' => 'clients', 'middleware' => 'web'], function ()
{
    Route::group(['as' => 'clients::'], function () {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ClientController@index'
        ]);

        Route::get('/save/{id?}', [
            'as' => 'create',
            'uses' => 'ClientController@create'
        ]);

        Route::post('/save/{id?}', [
            'as' => 'save',
            'uses' => 'ClientController@save'
        ]);

        Route::get('/list', [
            'as' => 'list',
            'uses' => 'ClientController@listAll'
        ]);

        Route::get('/delete/{id}', [
            'as' => 'delete',
            'uses' => 'ClientController@delete'
        ]);
    });
});
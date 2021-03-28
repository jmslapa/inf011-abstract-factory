<?php

use Mf\Routes\Route;

return [
    Route::group([        
        Route::get('/', 'IndexController@index'),
        Route::post('/highlight', 'IndexController@highlight'),
        Route::post('/compile', 'IndexController@compile')
    ])->namespace("App\\Http\\Controllers")
];
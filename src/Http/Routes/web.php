<?php

Route::name('surl.')->prefix('surl-management')->middleware('web')->group(function (){

//    App::setLocale('fa');

    Route::get('/','\Mniknab\Surl\Http\Controllers\SurlController@index')->name('list');

    Route::get('create','\Mniknab\Surl\Http\Controllers\SurlController@create')->name('create');
    Route::post('create','\Mniknab\Surl\Http\Controllers\SurlController@store')->name('store');

    Route::get('edit/{id}','\Mniknab\Surl\Http\Controllers\SurlController@edit')->name('edit');
    Route::put('edit/{id}','\Mniknab\Surl\Http\Controllers\SurlController@update')->name('update');

    Route::delete('destroy/{id}','\Mniknab\Surl\Http\Controllers\SurlController@destroy')->name('destroy');

});

Route::get('/surl/{identifier}','\Mniknab\Surl\Http\Controllers\RedirectController@redirect')->name('surl.redirect')->middleware('web');

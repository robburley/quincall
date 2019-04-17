<?php

Route::middleware('auth:api', 'active:api')->group(function () {
    Route::get('/keep-alive', 'Api\KeepAliveController@show');

    Route::post('/token', 'Api\TokenController@store');

    Route::get('/calls', 'Api\CallController@index');

    Route::post('/validate-phone-number', 'Api\ValidatePhoneNumberController@store');

    Route::get('/agent-stats', 'Api\AgentStatsController@index');
    Route::get('/stats', 'Api\StatsController@index');

    Route::post('/user/{user}/available', 'Api\UserAvailabilityController@update');
    Route::get('/user/{user}/missed-calls', 'Api\UserMissedCallController@index');
    Route::get('/user/{user}/voicemails', 'Api\UserVoicemailController@index');

    Route::middleware('administrator:api')->group(function () {
        Route::get('/reports/calls', 'Api\Reports\CallReportController@index');
        Route::get('/reports/productivity', 'Api\Reports\ProductivityReportController@index');
        Route::get('/reports/status', 'Api\Reports\StatusReportController@index');

        Route::get('/numbers', 'Api\NumberController@index');

        Route::get('/roles', 'Api\RoleController@index');

        Route::get('/users', 'Api\UserController@index');
        Route::post('/user', 'Api\UserController@store');
        Route::post('/users/{user}/destroy', 'Api\UserController@destroy');
    });
});

Route::post('/call', 'Api\CallRequestController@store');
Route::post('/calls/update', 'Api\CallController@update')->name('api.calls.update');
Route::post('/calls/recordings', 'Api\CallRecordingController@store')->name('api.calls.recordings.store');

Route::post('/user/presence', 'Api\UserPresenceController@update');
Route::post('/user/{user}/voicemails', 'Api\VoicemailController@store')->name('api.voicemails.store');

Route::post(
    '/voicemails/recordings',
    'Api\VoicemailRecordingController@store'
)->name('api.voicemails.recordings.store');

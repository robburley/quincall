<?php

Route::middleware('guest')->group(function () {
     Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
     Route::post('/login', 'Auth\LoginController@login');
 });

Route::middleware('auth', 'active')->group(function () {
    Route::any('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/', 'HomeController@index')->name('dashboard');

    Route::get('/calls/{call}/recording', 'CallRecordingController@show')->name('calls.recording.show');

    Route::get('/user/{user}/voicemails/{voicemail}', 'UserVoicemailController@show')->name('users.voicemails.show');

    Route::middleware('administrator')->group(function () {
        Route::name('reports.')
            ->namespace('Reports')
            ->prefix('/reports')
            ->group(function () {
                Route::get('/', 'ReportController@index')->name('index');

                Route::get('/calls', 'CallReportController@index')->name('calls.index');
                Route::get('/productivity', 'ProductivityReportController@index')->name('productivity.index');
                Route::get('/status', 'StatusReportController@index')->name('status.index');
            });

        Route::name('settings.')
            ->namespace('Settings')
            ->prefix('/settings')
            ->group(function () {
                Route::get('/', 'SettingsController@index')->name('index');
            });

        // Route::get('/delete-recordings', function () {
        //     $twilio = new \Twilio\Rest\Client(config('services.twilio')['accountSid'], config('services.twilio')['authToken']);
        //     $recordings = $twilio->recordings->read();
        //     foreach ($recordings as $recording) {
        //         $recording->delete();
        //     }
        // });
    });
});

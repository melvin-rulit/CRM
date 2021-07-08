<?php


// Route::get('/home', function () {
//     $routeName = auth()->user() && (auth()->user()->is_student || auth()->user()->is_teacher) ? 'admin.calendar.index' : 'admin.home';
//     if (session('status')) {
//         return redirect()->route($routeName)->with('status', session('status'));
//     }

//     return redirect()->route($routeName);
// });

Auth::routes(['register' => false]);

// Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
Route::group(['prefix' => '', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('/{any}', 'PagesController@index')->where('any', '.*');

    Route::get('journal', 'PagesController@journal');
    Route::get('permissions', 'PagesController@permissions');
    Route::get('agregator', 'PagesController@agregator');
    Route::get('kassa', 'PagesController@kassa');
    Route::get('kassa_setings', 'PagesController@kassaSetings');
    Route::get('users', 'PagesController@users');
    Route::get('roles', 'PagesController@roles');
    Route::get('useraccess', 'PagesController@useraccess');
    Route::get('page-region', 'PagesController@regions');
    Route::get('get', 'VueController@get');
    Route::get('get_email', 'VueController@getEmail');
    Route::post('getone', 'VueController@getOne');


    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::resource('lessons', 'LessonsController');

    // School Classes
    Route::delete('school-classes/destroy', 'SchoolClassesController@massDestroy')->name('school-classes.massDestroy');
    Route::resource('school-classes', 'SchoolClassesController');

    Route::get('calendar', 'CalendarController@index')->name('calendar.index');

    Route::resource('roleaccess', 'RoleAccessController');

    Route::get('/settings', 'SettingsController@index')->name('settings.index');

    Route::resource('region', 'RegionController');

    Route::resource('branch', 'BranchController');

    Route::get('/', 'PagesController@index')->middleware('promouter');

    Route::get('testing', 'PagesController@testing');

    //    Route::get('/', 'PagesController@index')->name('home');
//    Route::resource('useraccess', 'UserAccessController');
//    Route::get('base', 'PagesController@vue');
    // Permissions
    // Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    // Route::resource('permissions', 'PermissionsController');
//    Route::resource('roles', 'RolesController');

    // Users
//    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
//    Route::resource('users', 'UsersController');


});

Route::get('promouter', 'PagesController@promoter')->name('promouter');

<?php

Route::redirect('/', '/login');
// Route::get('/home', function () {
//     $routeName = auth()->user() && (auth()->user()->is_student || auth()->user()->is_teacher) ? 'admin.calendar.index' : 'admin.home';
//     if (session('status')) {
//         return redirect()->route($routeName)->with('status', session('status'));
//     }

//     return redirect()->route($routeName);
// });

Auth::routes(['register' => false]);
// Admin

// Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
Route::group(['prefix' => '', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('base', 'PagesController@vue');
    Route::get('journal', 'PagesController@journal');
    Route::get('permissions', 'PagesController@permissions');
    Route::get('agregator', 'PagesController@agregator');
    Route::get('kassa', 'PagesController@kassa');
    Route::get('operation', 'PagesController@operation');
    Route::get('users', 'PagesController@users');
    Route::get('page-region', 'PagesController@regions');
    Route::get('get', 'VueController@get');
    Route::get('get_email', 'VueController@getEmail');
    Route::post('getone', 'VueController@getOne');

    Route::get('/', 'PagesController@index')->name('home');
    // Permissions
    // Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    // Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
//    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
//    Route::resource('users', 'UsersController');

    // Lessons
    Route::delete('lessons/destroy', 'LessonsController@massDestroy')->name('lessons.massDestroy');
    Route::resource('lessons', 'LessonsController');

    // School Classes
    Route::delete('school-classes/destroy', 'SchoolClassesController@massDestroy')->name('school-classes.massDestroy');
    Route::resource('school-classes', 'SchoolClassesController');

    Route::get('calendar', 'CalendarController@index')->name('calendar.index');

    Route::resource('roleaccess', 'RoleAccessController');

    Route::resource('useraccess', 'UserAccessController');

    Route::get('/settings', 'SettingsController@index')->name('settings.index');

    Route::resource('region', 'RegionController');

    Route::resource('branch', 'BranchController');

    Route::get('/', 'PagesController@index');

//    Route::resource('promoter', 'BaseController');
    Route::get('promoter', 'PagesController@promoter');

});

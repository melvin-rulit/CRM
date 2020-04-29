<?php

// Route::resource('articles', 'Admin\ApiController');
// Route::post('getinfo', 'Api\V2\BaseController@getInfo');

Route::group(['prefix' => 'v2', 'as' => 'api.', 'namespace' => 'Api\V2'], function () {

    // Regions
    Route::apiResource('regions', 'RegionController');

    // Branches
    Route::apiResource('branches', 'BranchController');

    // Products
    Route::apiResource('products', 'ProductController');

    Route::post('getinfo', 'BaseController@getInfo');
    Route::get('collection', 'BaseController@index');
    Route::post('image', 'BaseController@upload');
    Route::get('getbranches', 'BaseController@getBranches');
    Route::post('addnewuser', 'BaseController@addNewUser');
    Route::post('getvmcontract', 'BaseController@getVmContract');
    Route::post('getcontract', 'ContractController@getContract');
    Route::post('getcontracts', 'ContractController@getContracts');
    Route::post('savecontract', 'ContractController@saveContractAndEditBaseFields');

    Route::post('test', 'BaseController@test');
});



Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Lessons
    Route::apiResource('lessons', 'LessonsApiController');

    // School Classes
    Route::apiResource('school-classes', 'SchoolClassesApiController');
});

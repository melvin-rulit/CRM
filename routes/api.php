<?php

// Route::resource('articles', 'Admin\ApiController');
// Route::post('getinfo', 'Api\V2\BaseController@getInfo');
//

Route::group(['prefix' => 'v2', 'as' => 'api.', 'namespace' => 'Api\V2', 'middleware' => ['auth']], function () {

    // Regions
    Route::apiResource('regions', 'RegionController');

    // Branches
    Route::apiResource('branches', 'BranchController');

    // Products
    Route::apiResource('products', 'ProductController');

    // DopProducts
    Route::apiResource('dopproducts', 'DopProductController');

    // DopProducts
    Route::apiResource('halls', 'HallController');

    // Schedule_hall
    Route::apiResource('schedule_hall', 'Schedule_hallController');

    // Programms
    Route::apiResource('programms', 'ProgrammController');
    Route::post('updateTypeProgramm', 'ProgrammController@updateTypeProgramm');

    // Groups
    Route::apiResource('groups', 'GroupController');

    // Product_pay
    Route::apiResource('product_pay', 'Product_payController');

    // Permissions
    Route::apiResource('apipermissions', 'PermissionsController');

    // Documents
    Route::apiResource('documents', 'DocumentController');

    // OperationTypes
    Route::apiResource('operation_type', 'OperationTypeController');

    // KassaOperation
    Route::get('kassa_operation', 'KassaOperationController@index');
    Route::post('addOperation', 'KassaOperationController@addOperation');
    Route::post('getOperationsType', 'KassaOperationController@getOperationsType');
    Route::post('getRadioButton', 'KassaOperationController@getRadioButton');

    // KassaGraoup
    Route::apiResource('kassaGroups', 'KassaGroupController');
    Route::post('kassas', 'KassaGroupController@getGroupInKassa');

    // Contracts
    Route::post('getcontract', 'ContractController@getContract');
    Route::post('getcontracts', 'ContractController@getContracts');
    Route::post('showcontract', 'ContractController@showContract');
    Route::post('savecontract', 'ContractController@saveContractAndEditBaseFields');

    // Journals
    Route::post('workout', 'BaseController@workout');
    Route::post('notVisit', 'BaseController@notVisit');
    Route::post('newWorkout', 'BaseController@newWorkout');
    Route::post('freezing', 'BaseController@freezing');
    Route::post('addNewComent', 'BaseController@addNewComent');
    Route::post('showHistory', 'BaseController@showHistory');
    Route::post('showhall', 'BaseController@showHall');
    Route::post('schedule', 'BaseController@Schedule');
    Route::post('deleteSchedule', 'BaseController@deleteSchedule');
    Route::post('saveSchedule', 'BaseController@saveSchedule');
    Route::post('getGroupInHall', 'BaseController@getGroupInHall');
    Route::post('getEditingGroup', 'BaseController@getEditingGroup');

    // Base
    Route::post('getinfo', 'BaseController@getInfo');
    Route::get('collection', 'BaseController@index');
    Route::get('getAgregatorLids', 'BaseController@getAgregatorLids');
    Route::post('image', 'BaseController@upload');
    Route::post('updateLpr', 'BaseController@updateLpr');
    Route::post('removeblock', 'BaseController@removeBlock');
    Route::post('changeCallDate', 'StatusesController@changeCallDate');
    Route::post('changeCallStatus', 'StatusesController@changeCallStatus');
    Route::post('addnewuser', 'BaseController@addNewUser');
    Route::get('filter', 'BaseController@filter');

    // Roles
    Route::apiResource('roles', 'RoleController');
    Route::get('getAllPermissions', 'RoleController@getAllPermissions');
    Route::post('saveRole', 'RoleController@saveRole');
    Route::post('saveRoleField', 'RoleController@saveRoleField');

    // UserAccess
    Route::get('userAccess', 'UserAccessController@index');
    Route::post('showUserAccess', 'UserAccessController@showUserAccess');
    Route::post('saveUserAccess', 'UserAccessController@saveUserAccess');

    // Users
    Route::apiResource('users', 'UserController');
    Route::get('getatributes', 'UserController@getAtributes');
    Route::post('history', 'UserController@history');
    Route::get('getUserName', 'UserController@getUserNameFromMenu');
    Route::get('getAllBranches', 'UserController@getAllBranches');
    Route::get('getAllRoles', 'UserController@getAllRoles');
    Route::post('saveBranches', 'UserController@saveBranches');
    Route::post('saveRoles', 'UserController@saveRoles');


    Route::post('addClientInGroup', 'BaseController@addClientInGroup');
    Route::post('saveClientInGroup', 'BaseController@saveClientInGroup');
    Route::post('updatetest', 'BaseController@updateTest');


    Route::post('getuseringroup', 'BaseController@getUserInGroup');
    Route::post('showprogramms', 'BaseController@showHProgramms');
    Route::post('uploadDocument', 'BaseController@uploadDocument');
    Route::post('gethalls', 'HallController@getHalls');
    Route::post('getgroup', 'GroupController@getgroup');
    Route::post('addClientFromPromoter', 'BaseController@addClientFromPromoter');


    Route::get('getbranches', 'BaseController@getBranches');
    Route::get('getmanagers', 'BaseController@getManagers');
    Route::get('getinstructors', 'BaseController@getInstructors');
    Route::post('getprogramms', 'BaseController@getProgramms');
    Route::get('getusers', 'BaseController@getUsers');
    Route::post('getvmcontract', 'BaseController@getVmContract');
    Route::get('test', 'BaseController@test');

    Route::get('getTest2', 'BaseController@getTest2');
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

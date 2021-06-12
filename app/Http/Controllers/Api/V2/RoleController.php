<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionsAllResource;
use App\Http\Resources\RolesAllResource;
use App\Http\Resources\ShowRoleResource;
use App\Permission;
use Illuminate\Http\Request;
use App\Role;
use Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::where('id', '>', 1)->get();


        return (RolesAllResource::collection($roles))
            ->additional([
                    'can' => [
                        'role_create'       => Gate::allows('role_create'),
                        'role_edit'         => Gate::allows('role_edit'),
                        'role_delete'         => Gate::allows('role_delete'),
                    ]
                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Role::create($request->all());
        $user->permissions()->sync($request->input('permissions', []));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new ShowRoleResource($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

     //--------------------------- Удаление Должности ----------------------------------//

    public function deleteRole(Request $request): string
    {

        $role = Role::find($request->id);

        $role->delete();

        return "Должность удалена";


    }

    public function getAllPermissions()
    {

        $permissions = Permission::all();

        return PermissionsAllResource::collection($permissions);
    }

    public function saveRole(Request $request)
    {

        $role = Role::find($request->id);

        $role->permissions()->sync($request->permissions);

    }

    public function saveRoleField(Request $request)
    {

        Role::find($request->id)->update([$request->field_name => $request->field_value]);

    }
}

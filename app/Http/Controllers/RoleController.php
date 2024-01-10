<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        if (!User::find(auth()->id())->can('view_roles')) {
            return abort(401);
        }

        if (\request()->ajax()) {
            $data = Role::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('permissions', function ($row) {
                    $output = '';
                    foreach ($row->permissions as $permission) {
                        $output .= '<div class="badge bg-primary m-1">' . $permission->name . '</div>';
                    }
                    return "<div class='d-flex flex-wrap'>" . $output . "</div>";
                })
                ->addColumn('actions', function ($row) {
                    $editIcon = '';
                    $deleteIcon = '';

                    if (User::find(auth()->id())->can('edit_role')) {
                        $editIcon = "<a href=" . route('roles.edit', $row->id) . " class='btn btn-sm btn-outline-warning'>" . "<i class='fa-solid fa-edit'></i>" . "</a>";
                    }

                    if (User::find(auth()->id())->can('delete_role')) {
                        $deleteIcon = "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger delete-btn'>" . "<i class='fa-solid fa-trash-alt'></i>" . "</a>";
                    }

                    return "<div class='btn-group'>$editIcon $deleteIcon</div>";
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'actions', 'permissions'])
                ->make(true);
        }
        return view('role.index');
    }

    public function create()
    {
        if (!User::find(auth()->id())->can('create_role')) {
            return abort(401);
        }

        return view('role.create', [
            "permissions" => Permission::all(),
        ]);
    }

    public function store(StoreRole $request)
    {
        if (!User::find(auth()->id())->can('create_role')) {
            return abort(401);
        }

        $role = new Role;
        $role->name = $request->name;
        $role->save();

        $role->givePermissionTo($request->permissions);

        return redirect(route('roles.index'))->with('created', 'New Role is created Successful');
    }

    public function edit($id,)
    {
        if (!User::find(auth()->id())->can('edit_role')) {
            return abort(401);
        }

        $role = Role::findOrFail($id);

        return view('role.edit', [
            'role' => $role,
            'permissions' => Permission::all(),
            'old_permissions_id' => $role->permissions->pluck('id')->toArray(),
        ]);
    }

    public function update($id, UpdateRole $request)
    {
        if (!User::find(auth()->id())->can('edit_role')) {
            return abort(401);
        }

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->update();

        $old_permissions = $role->permissions->pluck('name')->toArray();
        $role->revokePermissionTo($old_permissions);
        $role->givePermissionTo($request->permissions);

        return redirect(route('roles.index'))->with('updated', 'Role is updated Successful');
    }

    public function destroy($id)
    {
        if (!User::find(auth()->id())->can('delete_role')) {
            return abort(401);
        }

        $role = Role::findOrFail($id);
        $role->delete();

        return "success";
    }
}

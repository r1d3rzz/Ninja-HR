<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Permission::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('actions', function ($row) {
                    $editIcon = "<a href=" . route('permissions.edit', $row->id) . " class='btn btn-sm btn-outline-warning'>" . "<i class='fa-solid fa-edit'></i>" . "</a>";
                    $deleteIcon = "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger delete-btn'>" . "<i class='fa-solid fa-trash-alt'></i>" . "</a>";

                    return "<div class='btn-group'>$editIcon $deleteIcon</div>";
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'actions'])
                ->make(true);
        }
        return view('permission.index');
    }

    public function create()
    {
        return view('permission.create');
    }

    public function store()
    {
        $formData = request()->validate([
            'name' => ['required', Rule::unique('permissions', 'name')]
        ]);

        Permission::create($formData);

        return redirect(route('permissions.index'))->with('created', 'New Permission is created Successful');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permission.edit', [
            'permission' => $permission
        ]);
    }

    public function update($id)
    {
        $permission = Permission::findOrFail($id);

        request()->validate([
            'name' => ['required', Rule::unique('permissions', 'name')->ignore($id)]
        ]);

        $permission->name = request('name');
        $permission->update();

        return redirect(route('permissions.index'))->with('updated', 'Permission is updated Successful');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return "success";
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Role::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('actions', function ($row) {
                    $editIcon = "<a href=" . route('roles.edit', $row->id) . " class='btn btn-sm btn-outline-warning'>" . "<i class='fa-solid fa-edit'></i>" . "</a>";
                    $deleteIcon = "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger delete-btn'>" . "<i class='fa-solid fa-trash-alt'></i>" . "</a>";

                    return "<div class='btn-group'>$editIcon $deleteIcon</div>";
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'actions'])
                ->make(true);
        }
        return view('role.index');
    }

    public function create()
    {
        return view('role.create');
    }

    public function store()
    {
        $formData = request()->validate([
            'name' => ['required', Rule::unique('roles', 'name')]
        ]);

        Role::create($formData);

        return redirect(route('roles.index'))->with('created', 'New Role is created Successful');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('role.edit', [
            'role' => $role
        ]);
    }

    public function update($id)
    {
        $role = Role::findOrFail($id);

        request()->validate([
            'name' => ['required', Rule::unique('roles', 'name')->ignore($id)]
        ]);

        $role->name = request('name');
        $role->update();

        return redirect(route('roles.index'))->with('updated', 'Role is updated Successful');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return "success";
    }
}

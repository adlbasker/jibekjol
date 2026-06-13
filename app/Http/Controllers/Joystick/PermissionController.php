<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use App\Http\Controllers\Joystick\Controller;

use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        $permissions = Permission::all();

        return view('joystick.permissions.index', compact('permissions'));
    }

    public function create($lang)
    {
        $this->authorize('create', Permission::class);

        return view('joystick.permissions.create');
    }

    public function store(Request $request, $lang)
    {
        $this->authorize('create', Permission::class);

        $this->validate($request, [
            'name' => 'required|max:60|unique:permissions',
        ]);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect($lang.'/admin/permissions')->with('status', __('statuses.entry_added'));
    }

    public function edit($lang, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->authorize('update', $permission);

        return view('joystick.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
        ]);

        $permission = Permission::findOrFail($id);

        $this->authorize('update', $permission);

        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect($lang.'/admin/permissions')->with('status', __('statuses.entry_changed'));
    }

    public function destroy($lang, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->authorize('delete', $permission);

        $permission->delete();

        return redirect($lang.'/admin/permissions')->with('status', __('statuses.entry_deleted'));
    }
}

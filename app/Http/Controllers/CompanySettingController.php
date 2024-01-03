<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanySetting;
use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function show($id)
    {
        if (!User::find(auth()->id())->can('view_company_settings')) {
            return abort(401);
        }

        return view('company_setting.show', [
            'setting' => CompanySetting::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
        if (!User::find(auth()->id())->can('edit_company_settings')) {
            return abort(401);
        }

        return view('company_setting.edit', [
            'setting' => CompanySetting::findOrFail($id),
        ]);
    }

    public function update($id, UpdateCompanySetting $request)
    {
        if (!User::find(auth()->id())->can('edit_company_settings')) {
            return abort(401);
        }

        $setting = CompanySetting::findOrFail($id);
        $setting->name = $request->name;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->office_start_time = $request->office_start_time;
        $setting->office_end_time = $request->office_end_time;
        $setting->break_start_time = $request->break_start_time;
        $setting->break_end_time = $request->break_end_time;
        $setting->update();

        return redirect(route('company_settings.show', 1))->with('updated', 'Company Settings Updated');
    }
}

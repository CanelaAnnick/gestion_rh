<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'cnps_rate' => 'required|numeric|min:0|max:100',
            'tax_rate' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->except('_token', '_method') as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Paramètres sauvegardés avec succès !');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'company_name' => Setting::get('company_name', ''),
            'company_phone' => Setting::get('company_phone', ''),
            'company_email' => Setting::get('company_email', ''),
            'company_address' => Setting::get('company_address', ''),
            'currency_symbol' => Setting::get('currency_symbol', '৳'),
            'low_stock_threshold' => Setting::get('low_stock_threshold', '5'),
        ];
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'company_address' => 'nullable|string|max:500',
            'currency_symbol' => 'nullable|string|max:10',
            'low_stock_threshold' => 'nullable|integer|min:1',
        ]);

        $keys = ['company_name', 'company_phone', 'company_email', 'company_address', 'currency_symbol', 'low_stock_threshold'];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        if ($request->hasFile('company_logo')) {
            $request->validate(['company_logo' => 'image|mimes:png,jpg,jpeg|max:2048']);
            $path = $request->file('company_logo')->store('settings', 'public');
            Setting::set('company_logo', $path);
        }

        return redirect()->route('settings.index')->with('success', __('Settings updated successfully.'));
    }
}

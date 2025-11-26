<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('content.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'system_name' => 'nullable|string|max:255',
            'system_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'myTheme' => 'nullable|string|in:light,dark,system',
            'mySkins' => 'nullable|string|in:default,bordered',
            'hasSemiDark' => 'nullable|boolean',
            'myRTLMode' => 'nullable|boolean',
            'contentLayout' => 'nullable|string|in:compact,wide',
            'headerType' => 'nullable|string|in:fixed,static',
            'navbarType' => 'nullable|string|in:sticky,static,hidden',
            'menuFixed' => 'nullable|boolean',
            'menuCollapsed' => 'nullable|boolean',
            'footerFixed' => 'nullable|boolean',
            'primaryColor' => 'nullable|string', // For custom primary color
        ]);

        foreach ($request->all() as $key => $value) {
            if ($key === '_token' || $key === '_method') {
                continue;
            }

            $type = 'text';
            if ($key === 'system_logo' && $request->hasFile('system_logo')) {
                $file = $request->file('system_logo');
                $path = $file->store('public/settings');
                $value = Storage::url($path);
                $type = 'image';
            } elseif (in_array($key, ['hasSemiDark', 'myRTLMode', 'menuFixed', 'menuCollapsed', 'footerFixed'])) {
                $value = (bool) $value;
                $type = 'boolean';
            }

            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'type' => $type]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}

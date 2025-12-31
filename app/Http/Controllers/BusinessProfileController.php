<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessProfileController extends Controller
{
    public function create()
    {
        return view('business.setup');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024', // 1MB Max
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'currency' => 'required|string|size:3',
            'tax_rate' => 'nullable|numeric|between:0,100',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $request->user()->businessProfile()->create($validated);

        return redirect()->route('dashboard');
    }
}
